<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room'];

    const TYPE_ONE = 1;
    const TYPE_GROUP = 2;
}
