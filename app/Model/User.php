<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{

    protected $table = 'users';
    public $timestamps = true;
    protected $fillable = array('type', 'image', 'name', 'birth', 'email', 'active', 'is_verified');
    protected $hidden = array('password', 'rememberToken');

    public function news()
    {
        return $this->hasMany('App\Model\News');
    }

}