<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailValue extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'details_value';

    protected $fillable = [
        'name',
        'person_id',
        'category_id',
        'value_1',
        'value_2',
        'value_3',
        'value_4',
        'total',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}