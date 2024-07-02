<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Athlete extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'athlete';

    protected $fillable = [
        'athlete_name',
        'athlete_code',
        'date_of_entry',
        'date_of_birth',
        'long_time',
        'cabor',
        'email',
        'phone',
    ];
}
