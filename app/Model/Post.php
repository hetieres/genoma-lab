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

    public function historyLoad()
	{
		return PostHistory::where('id', $this->id)->orderBy('history_id', 'desc')->get();
    }

	public function history($history_id)
	{
		$history = PostHistory::where('id', $this->id)->where('history_id', $history_id)->first();
		$this->title          = $history->title;
		$this->summary        = $history->summary;
		$this->text           = $history->text;
		$this->id_youtube     = $history->id_youtube;
		$this->href           = $history->href;
		$this->live           = $history->live;
		$this->dt_publication = $history->dt_publication;
		$this->highlight      = $history->highlight;
		$this->active         = $history->active;
		$this->caption_image  = $history->caption_image;
		$this->session_id     = $history->session_id;
		$this->keywords       = $history->keywords;
        $this->user_id        = $history->user_id;
        $this->history_id     = $history_id;
	}

    public function maxMinHistory()
	{
		return PostHistory::selectRaw('max(history_id) as max, min(history_id) as min')->where('id', $this->id)->first();
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

    public function getImage(){
        if (!is_null($this->image) && file_exists(public_path($this->image))) {
            return asset($this->image);
        } else {
            return asset('assets/img/default.png');
        }
    }

}
