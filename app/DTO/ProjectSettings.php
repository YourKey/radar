<?php
namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class ProjectSettings extends DataTransferObject
{
    public int $update_range;
    public bool $telegram_fail_notify;
    public bool $telegram_success_notify;
}
