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
        'details_value_id',
        'person_id',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    public function detailsValue(): HasMany
    {
        return $this->hasMany(DetailValue::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Athlete::class, 'person_id');
    }
}
