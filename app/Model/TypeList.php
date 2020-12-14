<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeList extends Model
{

    protected $table = 'type_list';
    public $timestamps = true;
    protected $fillable = array('id', 'description');

    public function sessions()
    {
        return $this->hasMany('App\Model\Session');
    }

}