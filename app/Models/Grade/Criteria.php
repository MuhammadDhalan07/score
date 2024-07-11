<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\SortableTrait;

class Criteria extends Model implements Sortable
{
    use HasFactory, HasUlids, SoftDeletes;
    use SortableTrait;

    protected $table = 'criteria';

    protected $fillable = [
        'criteria_name',
        'priority',
        'sort',
        'parent_id',
        'value_id',
        'bobot',
    ];

    protected static function booted(): void
    {
        static::saved(function (Criteria $criteria)
        {
            $criteria->calculateAndSaveBobot();
        });
    }

    public function value(): BelongsTo
    {
        return $this->belongsTo(Value::class, 'value_id');  
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function sub(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
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

    public function scopeParentOnly(Builder $query)
    {
        $query->whereNull('parent_id');
    }

    public function scopeSubOnly(Builder $query)
    {
        $query->whereNotNull('parent_id');
    }

    public function calculateAndSaveBobot(): void
    {
        // Hitung bobot untuk kriteria
        if ($this->isParent()) {
            $kriteria = self::whereNull('parent_id')->orderBy('priority')->get();
            $totalKriteria = $kriteria->count();

            foreach ($kriteria as $k) {
                $bobot = 0;
                foreach (range(1, $totalKriteria) as $value) {
                    if ($k->priority <= $value) {
                        $bobot += 1 / $value;
                    }
                }
                $k->bobot = round($bobot / $totalKriteria, 3);
                $k->saveQuietly();
            }
        }

        if (! $this->isParent()) {
            $subCriteria = self::whereNotNull('parent_id')->orderBy('priority')->get();
            $groupedSubCriteria = $subCriteria->groupBy('parent_id')->map(function ($group) {
                return $group->groupBy('priority');
            });

            foreach ($groupedSubCriteria as $parent_id => $group) {
                $totalSubCriteria = $group->flatten()->count();

                foreach ($group as $priority => $items) {
                    foreach ($items as $s) {
                        $bobot = 0;
                        foreach (range(1, $totalSubCriteria) as $value) {
                            if ($s->priority <= $value) {
                                $bobot += 1 / $value;
                            }
                        }
                        $s->bobot = round($bobot / $totalSubCriteria, 3);
                        $s->saveQuietly();
                    }
                }
            }
        }
    }
}
