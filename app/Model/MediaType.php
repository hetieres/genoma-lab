<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model 
{

    protected $table = 'media_types';
    public $timestamps = true;
    protected $fillable = array('id', 'description');

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

}