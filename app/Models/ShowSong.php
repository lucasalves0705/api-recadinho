<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowSong extends  Model
{
    protected $fillable = [
        'show_id',
        'track_id'
    ];
}
