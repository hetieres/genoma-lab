<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DataImport extends Model
{

    protected $table = 'data_imports';
    public $timestamps = true;
    protected $fillable = array('news_id', 'news_import_id', 'url');
    protected $dates = ['created_at', 'updated_at', 'send_at'];

    public function news()
    {
        return $this->belongsTo('App\Model\News');
    }

}