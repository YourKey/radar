<?php

namespace App\Jobs;

use App\Actions\Notify\sendTelegramNotify;
use App\Actions\Pages\UpdateLastParseDate;
use App\Actions\storeErrorParserInfo;
use App\Actions\storeSnapshot;
use App\DTO\ParserResult;
use App\Models\Page;
use App\Models\Snapshot;
use App\Services\GuzzleParser;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class parseGuzzleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Page $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!$this->page->canBeParsed()) exit();
        $result = (new GuzzleParser($this->page->url, $this->page->get_filters))->parse();
        if ($result->status == 'ok') (new storeSnapshot($result, $this->page))->handle();
        if ($result->status == 'error') (new storeErrorParserInfo($result, $this->page))->handle();
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $e
     * @return void
     */
    public function failed(Throwable $e)
    {
        $result = new ParserResult(['message' => $e->getMessage(), 'status' => 'error']);
        (new storeErrorParserInfo($result, $this->page))->handle();
    }
}
