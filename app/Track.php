<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['code', 'from', 'to', 'dimansions', 'start_time', 'at_origin', 'freight_loaded', 'current_location', 'end_time', 'delivered', 'pod'];
}
