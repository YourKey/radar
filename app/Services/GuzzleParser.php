<?php

namespace App\Services;

use App\Abstracts\AbstractParser;
use App\DTO\PageFilters;
use App\DTO\ParserResult;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\Pure;

class GuzzleParser extends AbstractParser
{

    public function __construct(string $url, PageFilters $filters)
    {
        parent::__construct($url, $filters);
    }

    public function parse(): ParserResult
    {
        $html = Http::withoutVerifying()->get($this->url);
        $clean_html = (new FilterHtmlService())->cleanHtml($html->body());
        $filter_html = (new SelectorFilter())->filterBySelector(
            $clean_html,
            $this->filters->selector,
            $this->filters->type
        );

        return new ParserResult([
             'body' => $filter_html,
             'status' => $html->status(),
             'headers' => $html->headers()
        ]);

    }
}
