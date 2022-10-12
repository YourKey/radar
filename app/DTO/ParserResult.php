<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ParserResult extends DataTransferObject
{
    public ?string $body;
    public string $status;
    public ?int $http_status;
    public ?string $message;
    public ?array $headers;
}
