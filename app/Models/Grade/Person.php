<?php

namespace App\Models\Grade;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'person';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'nip',
    ];
}
