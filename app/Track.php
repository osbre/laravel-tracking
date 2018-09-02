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

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function getFromValueAttribute()
    {
        $destinations = $this->locations()->where('type', 'destination')->get();
        $freight_loads = $this->locations()->where('type', 'freight_loaded')->get();
        if (!$destinations->isEmpty()) {
            $from = $destinations->last()->value;
        } elseif (!empty($this->current_location)) {
            $from = $this->current_location;
        } elseif (!$freight_loads->isEmpty()) {
            $from = $freight_loads->last()->value;
        } elseif (!empty($this->at_origin)) {
            $from = $this->at_origin;
        } elseif (!empty($this->from)) {
            $from = $this->from;
        }

        return $from;
    }

    public function insertPhotos($request)
    {
        if ($request->hasFile('photos')) {
            $allowedFileExtension = ['jpeg', 'jpg', 'png'];
            $files = $request->file('photos');
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();

                $check = in_array($extension, $allowedFileExtension);

                if ($check) {

                    foreach ($request->photos as $photo) {
                        $filename = $photo->store('public/photos');

                        $this->photos()->create([
                            'filename' => $filename
                        ]);
                    }
                }
            }
        }
    }
}
