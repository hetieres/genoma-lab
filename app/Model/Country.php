<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model 
{

    protected $table = 'countries';
    public $timestamps = true;
    protected $fillable = array('id', 'description');

    public function vehicles()
    {
        return $this->hasMany('App\Model\Vehicle');
    }

}