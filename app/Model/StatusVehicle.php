<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatusVehicle extends Model 
{

    protected $table = 'status_vehicles';
    public $timestamps = true;
    protected $fillable = array('description');

    public function vehicles()
    {
        return $this->hasMany('App\Model\Vehicle');
    }

}