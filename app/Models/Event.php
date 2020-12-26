<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $dates = [
        'start_at',
        'expire_at'
    ];

    protected $fillable = [
        'name',
        'description',
        'start_at',
        'expire_at',
        'group_id',
    ];
}
