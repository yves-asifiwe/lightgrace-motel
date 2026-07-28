<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class motelmodel extends Model
{
    protected $table = 'rooms';
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'capacity',
    ];
}

  

