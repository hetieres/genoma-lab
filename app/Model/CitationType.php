<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CitationType extends Model 
{

    protected $table = 'citations_types';
    public $timestamps = true;
    protected $fillable = array('description');

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

}