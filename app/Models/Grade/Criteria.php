<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'criteria';

    protected $fillable = [
        'criteria_name',
        'priority',
        'quality',
        'athlete_id',
    ];

    
}
