<?php

namespace App\Models;

use App\DTO\PageFilters;
use App\DTO\ProjectSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'filters', 'project_id', 'parsed_at', 'parser_message'];

    protected $casts = [
        'filters' => 'json',
        'parsed_at' => 'datetime',
        'parser_message' => 'json',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(Snapshot::class)->orderByDesc('created_at');
    }

    public function snapshot()
    {
        return $this->snapshots()->first();
    }

    public function getSnapshotsUrlAttribute(): string
    {
        return route('projects.snapshots', [$this->project, $this]);
    }

    public function getGetFiltersAttribute(): PageFilters
    {
        return new PageFilters($this->filters);
    }

    public function getSnapshotLastUpdateAttribute(): Carbon
    {
        return $this->snapshot()->created_at;
    }

    public function canBeParsed(): bool
    {
        if ($this->parsed_at === null) return true;
        return Carbon::now()->diffInHours($this->parsed_at)+2 >= $this->project->get_settings->update_range;
    }
}
