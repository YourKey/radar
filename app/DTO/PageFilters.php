<?php
namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PageFilters extends DataTransferObject
{
    public ?string $type;
    public ?string $selector;
    public ?string $template;
    public ?string $removeSelector;
    public ?string $removeSelectorNew;
}
