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

    protected $fillable = ['url', 'filters', 'project_id'];

    protected $casts = [
        'filters' => 'json'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(Snapshot::class)->orderByDesc('created_at');
    }

    public function snapshot(): Snapshot
    {
        return $this->snapshots()->first();
    }

    public function getSnapshotsUrlAttribute(): string
    {
        return route('projects.snapshots', [$this->project, $this]);
    }

    public function getPageFiltersAttribute(): PageFilters
    {
//        $filters = $this->filters;
//        if (is_string($filters)) $filters = json_decode($this->filters, true);
        return new PageFilters($this->filters);
    }

    public function getSnapshotLastUpdateAttribute(): Carbon
    {
        return $this->snapshot()->created_at;
    }
}
