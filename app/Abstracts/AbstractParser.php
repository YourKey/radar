<?php

namespace App\Abstracts;


use App\DTO\PageFilters;
use App\DTO\ParserResult;

abstract class AbstractParser
{
    public string $url;
    public PageFilters $filters;

    public function __construct(string $url, PageFilters $filters)
    {
        $this->url = $url;
        $this->filters = $filters;
    }

    abstract public function parse(): ParserResult;
}
