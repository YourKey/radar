<?php

namespace App\Services;

use App\Abstracts\AbstractParser;
use App\DTO\PageFilters;
use App\DTO\ParserResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;

class GuzzleParser extends AbstractParser
{
    public function __construct(string $url, PageFilters $filters)
    {
        parent::__construct($url, $filters);
    }

    public function parse(): ParserResult
    {
        try {
            $response = Http::withoutVerifying()->get($this->url);
        } catch (\Exception $e) {
            return $this->httpErrorResult($e);
        }

        $html = $this->cleanHtml($response->body());
        if (!$html) return $this->emptyResult();

        return new ParserResult([
             'body' => $html,
             'status' => 'ok',
             'http_status' => $response->status(),
             'message' => $message ?? null,
             'headers' => $response->headers()
        ]);

    }

    private function cleanHtml($html): ?string
    {
        $clean_html = (new FilterHtmlService())->cleanHtml($html);
        return (new SelectorFilter())->filterBySelector(
            $clean_html,
            $this->filters->selector,
            $this->filters->type
        );
    }

    private function httpErrorResult($e): ParserResult
    {
        Log::error("Parse error: {$this->url}. {$e->getMessage()}");
        return new ParserResult([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
    }

    private function emptyResult(): ParserResult
    {
        Log::error("Empty parse result: {$this->url}");
        return new ParserResult([
            'status' => 'error',
            'message' => 'Парсер вернул пустой ответ. Возможно, неправильно выбран селектор.',
        ]);
    }
}
