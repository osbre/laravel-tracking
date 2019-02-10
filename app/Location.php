<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['value', 'type', 'track_id', 'date'];

    public $dates = ['date'];

    const UPDATED_AT = null; //disable updated_at field

    protected $touches = ['track'];

    public function setDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['date'] = Carbon::createFromFormat('m-d-Y H:i', $value);
        }
    }

    public function track()
    {
        return $this->belongsTo('App\Track');
    }
}
