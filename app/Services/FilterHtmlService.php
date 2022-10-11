<?php
namespace App\Services;

class FilterHtmlService
{
    private array $allowed_tags = [];

    public function __construct(?array $allowed_tags = null)
    {

        if ($allowed_tags !== null) {
            $this->allowed_tags = ['a', 'i', 'b', 'em', 'span', 'strong', 'ul', 'ol', 'li', 'table', 'tr', 'td', 'thead', 'th', 'tbody', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'head', 'body', 'meta', 'title', 'html', 'header', 'article', 'section'];
        } else {
            $this->allowed_tags = (array) $allowed_tags;
        }
    }

    // php native strip_tags
    public function strip(string $html): string
    {
        return strip_tags(trim($html), $this->allowed_tags);
    }

    public function cleanHtml(string $html): string
    {
        $str = html_entity_decode($html);

        // Strip HTML
        $str = preg_replace('#<br[^>]*?>#siu', "\n", $str);
        $str = preg_replace(
            [
/*                '#<head[^>]*?>.*?</head>#siu',*/
                '#<style[^>]*?>.*?</style>#siu',
                '#<script[^>]*?.*?</script>#siu',
                '#<object[^>]*?.*?</object>#siu',
                '#<embed[^>]*?.*?</embed>#siu',
                '#<applet[^>]*?.*?</applet>#siu',
                '#<noframes[^>]*?.*?</noframes>#siu',
                '#<noscript[^>]*?.*?</noscript>#siu',
                '#<noembed[^>]*?.*?</noembed>#siu',
                '#<!--.*?-->#ms',
            ],
            '',
            $str
        );
//        $str = strip_tags($str);

        // Trim whitespace
        $str = str_replace("\t", '', $str);
        $str = preg_replace('#\n\r|\r\n#', "\n", $str);
        $str = preg_replace('#\n{3,}#', "\n\n", $str);
        $str = trim($str);

        return $str;
    }
}
