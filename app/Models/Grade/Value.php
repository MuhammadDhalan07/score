<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Value extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'value';

    protected $fillable = [
        'real_value',
        'rank',
        'person_id',
        'criteria_id',
    ];

    protected $casts = [
        'criteria_id' => 'array',
    ];
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }


    public function person(): BelongsTo
    {
        return $this->belongsTo(Athlete::class, 'person_id');
    }
}
