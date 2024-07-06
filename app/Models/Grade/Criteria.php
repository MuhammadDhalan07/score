<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EloquentSortable\SortableTrait;

class Criteria extends Model implements Sortable
{
    use HasFactory, HasUlids, SoftDeletes;
    use SortableTrait;

    protected $table = 'criteria';

    protected $fillable = [
        'criteria_name',
        'priority',
        'quality',
        'athlete_id',
        'sort',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function isParent(): bool
    {
        return ! $this->parent_id;
    }

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->where([
                'parent_id' => $this->parent_id,
            ]);
    }

    public function scopeIndukOnly(Builder $query)
    {
        $query->whereNull('parent_id');
    }

    public function scopeSubOnly(Builder $query)
    {
        $query->whereNotNull('parent_id');
    }
}
