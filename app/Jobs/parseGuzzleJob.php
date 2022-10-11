<?php

namespace App\Jobs;

use App\Models\Page;
use App\Models\Snapshot;
use App\Services\GuzzleParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $data = (new GuzzleParser($this->page->url, $this->page->page_filters))->parse();
        if ($data->status == 200) {
            $snapshot = new Snapshot();
            $snapshot->data = $data->body;
            $snapshot->page_id = $this->page->id;
            $snapshot->save();
        }
    }
}
