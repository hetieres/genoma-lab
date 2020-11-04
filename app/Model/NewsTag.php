<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model 
{

    protected $table = 'news_tags';
    protected $primaryKey = ['news_id', 'tag_id'];
    protected $fillable = ['news_id', 'tag_id'];

    public $incrementing = false;

    public $timestamps = true;

    public function news()
    {
        return $this->hasOne('News');
    }

    public function tag()
    {
        return $this->hasOne('Tag');
    }

}