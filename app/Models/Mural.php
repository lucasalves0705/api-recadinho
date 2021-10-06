<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mural extends  Model
{
    protected $table = 'mural';

    protected $fillable = [
        'user_id',
        'message'
    ];
}
