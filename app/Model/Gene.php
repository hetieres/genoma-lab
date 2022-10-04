<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gene extends Model
{

    protected $table = 'genes';
    public $timestamps = true;
    protected $fillable = array('description');

}