<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model 
{

    protected $table = 'tags';
    public $timestamps = true;

    public function newsTags()
    {
        return $this->hasMany('App\Model\NewsTag');
    }

}