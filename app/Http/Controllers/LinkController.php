<?php

namespace App\Http\Controllers;

use App\Model\Url;
use App\Model\News;
use App\Model\UrlType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;

class LinkController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['types'] = UrlType::orderBy('description')->get();
        return view('admin.urlEdit', $this->data);
    }

    public function save(Request $request)
    {
        $urls     = explode("\n", $request->url);
        $pending  = 0;
        $register = 0;
        foreach ($urls as $url) {
            $url = trim($url);
            if(filter_var($url, FILTER_VALIDATE_URL))
            {
                $like  = explode("://", $url);
                $like  = isset($like[1]) ? '%' . trim($like[1]): $like[0];
                $model = Url::where('url', 'like', $like)->first();
                if($model === null){
                    $model      = new Url();
                    $model->url = $url;
                }
                $model->register    = News::where('url', 'like', $like)->count() > 0 ? 1: 0;
                $model->url_type_id = $request->url_type_id;
                $model->topic       = $request->topic;
                if($model->save())
                {
                    if($model->register)
                        $register++;
                    else
                        $pending++;

                }
            }
        }
        return json_encode((object)["pending" => $pending, "register" => $register]);
    }

    public function verify(Request $request)
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $url = Url::where('url', 'LIKE', '%?%')->get();
        // dd('aqui');
        foreach ($url as $item) {
            $like = explode("://", $item->url);
            $like = isset($like[1]) ? trim($like[1]) : $like[0];
            $like = explode("?", $like);
            $like = '%' . $like[0] . '%';
            $aux  = News::where('url', 'like', $like)->count() == 1 ? 1 : 0;
            if($aux)
                echo $item->url . ' - ' . $aux . "<br>";
        }
    }

    public function list(Request $request)
    {
        $rs = Url::query();

        if(isset($request->register) && $request->register !== '')
            $rs->where('register', $request->register);

        if(isset($request->type) && $request->type !== '')
            $rs->where('url_type_id', $request->type);

        if(isset($request->daterange) && $request->daterange != ''){
            $dates = explode(',', $request->daterange);
            $rs->where('created_at', '>=', $dates[0] . ' 00:00:00')
                ->where('created_at', '<=', $dates[1] . ' 23:59:59');
        }

        if(isset($request->key) && trim(isset($request->key)) != '')
        {
            $key  = explode("://", $request->key);
            $key  = isset($key[1]) ? addslashes(trim($key[1])) : addslashes($key[0]);
            $rs->where(function($query) use ($request, $key){
                $query->where('url', 'LIKE', "%$key%");
                $query->orWhere('topic', 'LIKE', "%" . $request->key . "%");
            });
        }

        switch ($request->order) {
            case '0':
                $rs->orderBy('created_at', 'DESC');
                break;
            case '1':
                $rs->orderBy('url')->orderBy('topic');
                break;
            case '2':
                $rs->orderBy('topic');
                break;
        }

        $rs = $rs->paginate(25);

        foreach ($rs as $item) {
            $item->date = $item->created_at->format('d/m/Y H:i');
            $item->type = $item->type;
        }

        $return               = array();
        $return['rs']         = $rs;
        $return['rangePages'] = (object) $this->rangePages($rs->lastPage(), $rs->currentPage());
        $return               = (object) $return;

        return json_encode($return);

    }

    public function report()
    {
        $this->data['types'] = json_encode(UrlType::orderBy('description')->get());
        return view('admin.urlReport', $this->data);
    }

    public function download(Request $request)
    {
        $rs = Url::query();

        if(isset($request->register) && $request->register !== '')
            $rs->where('register', $request->register);

        if(isset($request->type) && $request->type !== '')
            $rs->where('url_type_id', $request->type);

        if(isset($request->daterange) && $request->daterange != ''){
            $dates = explode(',', $request->daterange);
            $rs->where('created_at', '>=', $dates[0] . ' 00:00:00')
                ->where('created_at', '<=', $dates[1] . ' 23:59:59');
        }

        if(isset($request->key) && trim(isset($request->key)) != '')
        {
            $key  = explode("://", $request->key);
            $key  = isset($key[1]) ? addslashes(trim($key[1])) : addslashes($key[0]);
            $rs->where(function($query) use ($request, $key){
                $query->where('url', 'LIKE', "%$key%");
                $query->orWhere('topic', 'LIKE', "%" . $request->key . "%");
            });
        }

        $this->data['total'] = $rs->count();
        $this->data['data']  = $rs->orderBy('url')->get();

        header('Content-type: application/excel');
        header('Content-Disposition: attachment; filename=urls.xls');
        header("Pragma: ");
        header("Cache-Control: ");
        return view('admin.urlReportList', $this->data);
    }

    public function delete(Request $request)
    {
        $rs = Url::where('url', '=', $request->url)->delete();
        return $rs;
    }

}
