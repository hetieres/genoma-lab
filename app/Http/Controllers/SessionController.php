<?php

namespace App\Http\Controllers;

use DateTime;
use App\Model\Post;
use App\Model\Session;
use App\Model\TypeList;
use App\Model\PostHistory;
use Caxy\HtmlDiff\HtmlDiff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SessionController extends Controller
{
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        if ($request->input('id') > 0) {
            $model = Session::findOrFail($request->input('id'));
        } else {
            $model = new Session();
        }

        $model->description  = $request->input('description');
        $model->type_list_id = $request->input('type_list_id');
        $model->url          = $request->input('url');
        $model->color        = $request->input('color');
        $model->aside        = $request->input('aside');
        $model->ids          = (strlen($request->input('ids')) > 0 ? json_encode(explode(',', $request->input('ids'))): '');
        $model->user_id      = $request->user_id;

        //salva
        $model->save();

        return $model;
    }


    public function edit(Request $request)
    {

        if (isset($request->id) && $request->id > 0) {
            $session      = Session::find($request->id);
            $session->ids = $session->ids ? json_decode($session->ids): false;
            $session->url = $session->url ? $session->url : str_slug($session->description);
            $highlight    = false;

            if($session->ids){
                $highlight = Post::whereIn('id', $session->ids);
                foreach ($session->ids as $item) {
                    $highlight->orderByRaw('id=' . $item . ' desc');
                }
                 $highlight =  $highlight->get();
            }

            $this->data['session']   = $session;
            $this->data['types']     = TypeList::all();
            $this->data['highlight'] = $highlight;
            $this->data['user_id']   = Auth::user()->id;

            return view('admin.sessionEdit', $this->data);
        }

    }


}
