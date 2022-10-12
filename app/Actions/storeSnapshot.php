<?php

namespace App\Actions;

use App\Actions\Notify\sendTelegramNotify;
use App\DTO\ParserResult;
use App\Models\Page;
use App\Models\Snapshot;
use Carbon\Carbon;

class storeSnapshot
{
    public ParserResult $result;
    public Page $page;

    public function __construct(ParserResult $result, Page $page)
    {
        $this->result = $result;
        $this->page = $page;
    }

    public function handle(): void
    {
        $snapshot = new Snapshot();
        $snapshot->data = $this->result->body;
        $snapshot->page_id = $this->page->id;
        $snapshot->save();

        $this->page->parsed_at = Carbon::now();
        $this->page->parser_message = null;
        $this->page->save();
        if ($this->page->project->get_settings->telegram_success_notify)(new sendTelegramNotify("#success_parse\n{$this->page->url}"))->send();
    }
}
