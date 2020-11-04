<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['title', 'summary', 'text', 'dt_publication', 'category_id', 'media_type_id', 'vehicle_id', 'lang_id', 'id', 'news_status_id', 'citation_type_id', 'author', 'publishing', 'image', 'caption_image', 'highlight', 'pages', 'url', 'url_fapesp', 'viewed', 'number_process', 'number_researcher'];
    protected $dates = ['created_at', 'updated_at', 'dt_publication'];
    public $timestamps = true;

    public static function statusActive() {
        return [2, 5];
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function citationType()
    {
        return $this->belongsTo('App\Model\CitationType');
    }

    public function mediaType()
    {
        return $this->belongsTo('App\Model\MediaType');
    }

    public function dataImport()
    {
        return $this->belongsTo('App\Model\DataImport');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\NewsStatus', 'news_status_id', 'id');
    }

    public function lang()
    {
        return $this->belongsTo('App\Model\Lang');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Model\Vehicle');
    }

    public function vehicles()
    {
        return $this->hasMany('App\Model\Vehicle', 'id', 'vehicle_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function tags()
    {
        return $this->hasMany('App\Model\NewsTag', 'news_id', 'id');
    }

}