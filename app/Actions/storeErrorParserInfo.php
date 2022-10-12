<?php

namespace App\Actions;

use App\Actions\Notify\sendTelegramNotify;
use App\DTO\ParserResult;
use App\Models\Page;
use Carbon\Carbon;

class storeErrorParserInfo
{
    public ParserResult $result;
    public Page $page;

    public function __construct(ParserResult $result, Page $page)
    {
        $this->result = $result;
        $this->page = $page;
    }

    public function handle()
    {
        $this->page->parser_message = $this->result;
        $this->page->parsed_at = Carbon::now();
        $this->page->save();
        if ($this->page->project->get_settings->telegram_fail_notify) (new sendTelegramNotify("#parser_error\n{$this->page->url}\n{$this->result->message}"))->send();
    }
}
