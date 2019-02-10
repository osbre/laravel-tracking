<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = ['filename', 'track_id'];

    protected $touches = ['track'];

    const UPDATED_AT = null; //disable updated_at field

    public function track()
    {
        return $this->belongsTo('App\Track');
    }

    /*
      TODO - with photo, too delete file
    public function delete()
    {
        Storage::delete($this->filename);
        parent::delete();
    }*/
}
