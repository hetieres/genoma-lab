<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'sessions';
    public $timestamps = true;
    protected $fillable = array('description');

    public function posts()
    {
        return $this->hasMany('App\Model\Post');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}