<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Value extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $fillable = [
        'details_value_id',
        'person_id',
    ];
}
