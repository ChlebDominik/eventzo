<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musician extends Model
{
    protected $fillable = ['name', 'genre'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}