<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UrlType extends Model
{

    protected $table = 'urls_types';
    public $timestamps = true;
    protected $fillable = array('description');

    public function urls()
    {
        return $this->hasMany('App\Model\Url');
    }

}