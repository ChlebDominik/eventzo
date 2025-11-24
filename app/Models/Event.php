<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'capacity',
        'image'
    ];

    protected $dates = [
        'start_date'
    ];
}
