<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['code', 'from', 'to', 'load', 'dims', 'at_origin', 'at_origin_date', 'freight_loaded', 'freight_loaded_date', 'current_location', 'current_location_date', 'at_distination', 'at_distination_date', 'delivered', 'status', 'pod'];
}
