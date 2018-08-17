<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['code', 'from', 'to', 'start_time', 'end_time'];
}
