<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model 
{

    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = array('description');

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

}