<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewsStatus extends Model
{

    protected $table = 'news_status';
    public $timestamps = true;
    protected $fillable = array('description');

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

}