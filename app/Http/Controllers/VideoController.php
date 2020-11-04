<?php

namespace App\Http\Controllers;

use DateTime;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\json_decode;

class VideoController extends Controller
{
    //
    public function index()
    {
        return view('admin.videoList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        if ($request->input('id') > 0) {
            $model = Video::findOrFail($request->input('id'));
        } else {
            $model = new Video();
        }

        $model->title = $request->input('title');
        $model->summary = $request->input('summary');
        $model->text = $request->input('text');
        $model->dt_publication = $request->input('dt_publication') != '' ? DateTime::createFromFormat('d/m/Y', $request->input('dt_publication'))->format('Y-m-d') : '';
        $model->highlight = $request->input('highlight') == 'true' ? 1 : 0;
        $model->active = $request->input('active') == 'true' ? 1 : 0;
        $model->caption_image = $request->input('caption_image');
        $model->session_id = $request->input('session_id');
        $model->keywords = (strlen($request->input('keywords')) > 0 ? json_encode(explode(',', $request->input('keywords'))) : '');

        $image = $request->file('image');
        if ($request->hasFile('image') && $image->isValid()) {
            $fileInfo = pathinfo($image->getClientOriginalName());
            $extension = $fileInfo['extension'];
            $fileName = $model->id . '.' . $extension;

            $upload = $image->storeAs($this->_public_path . '/post', $fileName);
            if ($upload)
                $model->image = str_replace($this->_public_path, $this->_uploads_path, $upload);
            else
                $model->image = '';
        }

        //salva materia
        $model->save();

        //ajuste de imagem
        if ($model->image != '')
            $model->image = asset($model->image) . '?' . time();

        return $model;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageEditView(Request $request)
    {
        $image = $request->file('image');
        if ($request->hasFile('image') && $image->isValid()) {
            $fileInfo = pathinfo($image->getClientOriginalName());
            $extension = $fileInfo['extension'];
            $fileName = 'post.' . $extension;

            $upload = $image->storeAs($this->_public_path . '/post', $fileName);
            $image = str_replace($this->_public_path, $this->_uploads_path, $upload);
        }

        return asset($image) . '?' . time();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Request $request)
    {

        if ($request->input('id') > 0) {
            $model = Post::find($request->input('id'));

            if (!is_null($model->image) && file_exists($model->image)) {
                Storage::delete(str_replace($this->_uploads_path, $this->_public_path, $model->image));
            }

            $model->image = '';
            $model->save();
        } else {
            $model = new Post();
        }

        return $model;
    }

    public function edit(Request $request)
    {
        $post = new Post(['active' => 1]);

        if (isset($request->id) && $request->id > 0) {
            $post = Post::find($request->id);
        }

        if ($post !== '' && !is_null($post->image) && file_exists(public_path($post->image))) {
            $post->image = asset($post->image) . '?' . time();
        } else {
            $post->image = '';
        }

        if ($post->keywords) {
            $post->keywords = json_decode($post->keywords);
        }

        $this->data['post'] = $post;
        $this->data['user_id'] = Auth::user()->id;
        $this->data['sessions'] = Session::orderBy('description')->get()->toArray();

        return view('admin.postEdit', $this->data);
    }

    public function list(Request $request)
    {
        $rs = Post::query();

        if (isset($request->session_id) && $request->session_id > 0)
            $rs->where('session_id', $request->session_id);

        if (isset($request->daterange) && $request->daterange != '') {
            $dates = explode(',', $request->daterange);
            $rs->where('dt_publication', '>=', $dates[0])
                ->where('dt_publication', '<=', $dates[1]);
        }

        if (isset($request->key) && $request->key != '') {
            if ((int)$request->key > 0) {
                $rs->where('id', $request->key);
            } else {
                $key = '%' . addslashes($request->key) . '%';
                $rs->where(function ($query) use ($key) {
                    $query->where('title', 'like', $key)
                        ->orWhere('text', 'like', $key)
                        ->orWhere('summary', 'like', $key);
                });
            }
        }

        if (!isset($request->order) || $request->order == 0) {
            $rs->orderBy('dt_publication', 'desc');
        } else if ($request->order == 1) {
            $rs->orderBy('updated_at', 'desc');
        } else if ($request->order == 2) {
            $rs->orderBy('dt_publication');
        }
        $rs = $rs->paginate(25);

        foreach ($rs as $item) {
            $item->session = $item->session;
            $item->date = isset($item->dt_publication) ? $item->dt_publication->format('d/m/Y') : ' - ';
        }
        $lastPage = $rs->lastPage();
        $currentPage = $rs->currentPage();

        $return = array();
        $return['rs'] = $rs;
        $return['rangePages'] = $this->rangePages($lastPage, $currentPage);
        $return['rangePages'] = (object)$return['rangePages'];
        $return = (object)$return;

        return \Response::json($return);
    }

    public function delete(Request $request)
    {
        $ids = explode('-', $request->input('id'));
        $deletedRows = Post::whereIn('id', $ids)->delete();

        return $deletedRows;
    }


}
