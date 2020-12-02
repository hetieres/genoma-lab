<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostHistory extends Model
{
    protected $table = 'posts_history';
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
