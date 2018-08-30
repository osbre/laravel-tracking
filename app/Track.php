<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['code', 'from', 'to', 'load_pc', 'load_lbs', 'dims', 'at_origin', 'at_origin_date', 'current_location', 'current_location_date', 'delivered', 'status', 'pod'];

    protected $dates = ['at_origin_date', 'current_location_date', 'at_distination_date', 'delivered'];

    public function setAtOriginDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['at_origin_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }

    public function setCurrentLocationDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['current_location_date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }

    public function setDeliveredAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['delivered'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }

    /**
     * Check, is now user must update track (user must update track every two hours)
     * @return boolean
     */
    public function getIsUpdateExpiredAttribute()
    {
        $date = $this->updated_at->addHour(2);
        $now = Carbon::now();
        return $date->lessThan($now);
    }

    public function locations()
    {
        return $this->hasMany('App\Location');
    }
}
