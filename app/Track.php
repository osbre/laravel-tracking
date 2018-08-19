<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['code', 'from', 'to', 'load', 'dims', 'at_origin', 'at_origin_date', 'freight_loaded', 'freight_loaded_date', 'current_location', 'current_location_date', 'at_distination', 'at_distination_date', 'delivered', 'status', 'pod'];

    public function setAtOriginDateAttribute($value)
    {
        $this->attributes['at_origin_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
    }

    public function setFreightLoadedDateAttribute($value)
    {
        $this->attributes['freight_loaded_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
    }

    public function setCurrentLocationDateAttribute($value)
    {
        $this->attributes['current_location_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
    }

    public function setAtDistinationDateAttribute($value)
    {
        $this->attributes['at_distination_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
    }

    public function setDeliveredAttribute($value)
    {
        $this->attributes['delivered'] = Carbon::createFromFormat('m-d-Y H:i', $value);
    }
}
