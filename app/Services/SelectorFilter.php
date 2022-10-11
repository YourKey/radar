<?php

namespace App\Services;
use voku\helper\HtmlDomParser;

class SelectorFilter
{
    public function filterBySelector(string $html, ?string $selector, ?string $type = 'html'): ?string
    {
        if ($selector === null) return $html;
        $dom = HtmlDomParser::str_get_html($html);
        $selected = $dom->find($selector);
        if (!isset($selected[0])) return null;
        return $selected[0]->$type;
    }
}
