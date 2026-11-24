<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'description', 'image'];

    protected $casts = [
        'date' => 'date',
    ];
}
