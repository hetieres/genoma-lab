<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $table = 'vehicles';
    public $timestamps = true;
    protected $fillable = array('description', 'country_id', 'status_vehicle_id', 'media_type_id', 'state', 'city', 'url', 'import_id', 'unify_id', 'big', 'user_id');

    public function status()
    {
        return $this->belongsTo('App\Model\StatusVehicle', 'status_vehicle_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function mediaType()
    {
        return $this->belongsTo('App\Model\MediaType');
    }

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}