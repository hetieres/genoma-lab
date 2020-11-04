<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    protected $fillable = ['id', 'id_youtube', 'title', 'summary'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;
    public static function DadosVideos($limit)
    {
        return Video::orderBy('id', 'DESC')->limit($limit)->get();
    }
}
