<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
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
        'sort'
    ];
    
}
