<?php

namespace App\Models;

use App\DTO\ProjectSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
      'settings' => 'json'
    ];
    protected $fillable = ['name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class)->orderByDesc('created_at');
    }

    public function snapshots(): HasManyThrough
    {
        return $this->hasManyThrough(Snapshot::class, Page::class);
    }

    public function getGetSettingsAttribute(): ProjectSettings
    {
        return new ProjectSettings($this->settings);
    }
}
