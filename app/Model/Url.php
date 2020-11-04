<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{

    protected $table = 'urls';
    public $timestamps = true;
    protected $fillable = array('url');

    protected $primaryKey = 'url';

    public $incrementing = false;
    public $keyType = 'string';

    public function type()
    {
        return $this->belongsTo('App\Model\UrlType', 'url_type_id', 'id');
    }

}