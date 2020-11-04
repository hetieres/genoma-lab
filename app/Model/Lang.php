<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model 
{

    protected $table = 'langs';
    public $timestamps = true;
    protected $fillable = array('description');

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

}