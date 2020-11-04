<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title', 'summary', 'text', 'dt_publication', 'session_id', 'active', 'highligth', 'user_id', 'id', 'image', 'caption_image'];
    protected $dates = ['created_at', 'updated_at', 'dt_publication'];
    public $timestamps = true;

    public function session()
    {
        return $this->belongsTo('App\Model\Session');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public static function DadosPost($id, $limit)
    {
        return Post::selectRaw('posts.id, posts.summary, posts.title, posts.text, posts.id_youtube , posts.href ,posts.image,posts.highlight')
            ->join('sessions', 'sessions.id', '=', 'posts.session_id')
            ->where('posts.session_id', '=', $id)
            ->where('posts.highlight', '=', 1)
            ->limit($limit)
            ->orderBy('posts.dt_publication', 'desc')
            ->get();
    }

    public function link(){
        $return = false;
        if($this->href && $this->href != "null"){
            $return = $this->href;
        }else {
            $return = route('detalhe', ['title' => str_slug($this->title), 'id' => $this->id]);
        }
        return $return;
    }

    public static function statusActive() {
        return [1];
    }

}
