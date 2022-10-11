<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ParserResult extends DataTransferObject
{
    public string $body;
    public int $status;
    public array $headers;
}
