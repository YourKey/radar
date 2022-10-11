<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Snapshot extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'data'];

    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }
}
