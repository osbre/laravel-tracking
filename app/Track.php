<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['code', 'from', 'to', 'load', 'dims', 'at_origin', 'at_origin_date', 'freight_loaded', 'freight_loaded_date', 'current_location', 'current_location_date', 'at_distination', 'at_distination_date', 'delivered', 'status', 'pod'];

    protected $dates = ['at_origin_date', 'freight_loaded_date', 'current_location_date', 'at_distination_date', 'delivered'];

    public function setAtOriginDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['at_origin_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }

    public function setFreightLoadedDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['freight_loaded_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }

    public function setCurrentLocationDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['current_location_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }

    }

    public function setAtDistinationDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['at_distination_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }

    }

    public function setDeliveredAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['delivered'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }
}
