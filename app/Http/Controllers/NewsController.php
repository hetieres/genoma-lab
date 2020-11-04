<?php

namespace App\Http\Controllers;

use DateTime;
use App\Model\Tag;
use App\Model\Url;
use App\Model\News;
use App\Model\NewsTag;
use App\Model\Vehicle;
use App\Model\Category;
use App\Model\MediaType;
use App\Model\NewsStatus;
use App\Model\CitationType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    //
    public function index()
    {
        return view('admin.newsList', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUpdate(Request $request)
    {
        if($request->input('id') > 0)
        {
            $model = News::findOrFail($request->input('id'));
            $old   = $model;
        }else{
            $model  = new News();
            $errors = $this->urlUnique($request->input('url'));
            if(count($errors) > 0){
                return ['errors' => $errors];
            }
        }

        $model->title             = $request->input('title');
        $model->summary           = $request->input('summary');
        $model->text              = $request->input('text');
        $model->dt_publication    = $request->input('dt_publication') != '' ? DateTime::createFromFormat('d/m/Y', $request->input('dt_publication'))->format('Y-m-d'): '';
        $model->highlight         = $request->input('highlight') == 'true' ? 1 : 0;
        $model->caption_image     = $request->input('caption_image');
        $model->news_status_id    = $request->input('news_status_id');
        $model->category_id       = $request->input('category_id');
        $model->citation_type_id  = $request->input('citation_type_id');
        $model->media_type_id     = $request->input('media_type_id');
        $model->vehicle_id        = $request->input('vehicle_id');
        $model->author            = $request->input('author');
        $model->publishing        = $request->input('publishing');
        $model->pages             = $request->input('pages');
        $model->url               = $request->input('url');
        $model->url_fapesp        = $request->input('url_fapesp');
        $model->user_id           = $request->input('user_id');
        $model->number_process    = (strlen($request->input('number_process')) > 0 ? json_encode(explode(',', $request->input('number_process'))) : '');
        $model->number_researcher = (strlen($request->input('number_researcher')) > 0 ? json_encode(explode(',', $request->input('number_researcher'))) : '');
        $tags                     = (strlen($request->input('tags')) > 0 ? json_encode(explode(',', $request->input('tags'))) : false);

        $urls = explode("\n", $request->input('url'));
        if($request->input('id') == null && $this->urlsMultipleCheck($urls))
        {
            return $this->urlsMultipleSave($model, $urls);
        }

        if($model->vehicle->unify_id)
        {
            $model->vehicle_id = $model->vehicle->unify_id;
        }


        $image = $request->file('image');
        if($request->hasFile('image') && $image->isValid())
        {
            $fileInfo  = pathinfo($image->getClientOriginalName());
            $extension = $fileInfo['extension'];
            $fileName  = $model->id . '.' . $extension;

            $upload    = $image->storeAs($this->_public_path.'/news', $fileName);
            if($upload)
                $model->image = str_replace($this->_public_path, $this->_uploads_path, $upload);
            else
                $model->image = '';
        }

        if($request->input('id') > 0)
        {
            //resutset de materia iguais
            $rsEquals = News::where('title', '=', $old->title)
                            ->where('text', '=', $old->text)
                            ->where('news_status_id', '=', 12)
                            ->get();

            //acerta materias de titulo e texto iguais
            News::where('title', '=', $old->title)
                    ->where('text', '=', $old->text)
                    ->where('news_status_id', '=', 12)
                    ->update([
                        'url_fapesp'        => $model->url_fapesp,
                        'category_id'       => $model->category_id,
                        'citation_type_id'  => $model->citation_type_id,
                        'news_status_id'    => $model->news_status_id,
                        'author'            => $model->author,
                        'title'             => $model->title,
                        'text'              => $model->text,
                        'number_process'    => $model->number_process,
                        'number_researcher' => $model->number_researcher
                    ]);

            //acerta materias de titulo iguais
            News::where('title', '=', $old->title)
                    ->where('news_status_id', '=', 12)
                    ->update([
                        'url_fapesp'        => $model->url_fapesp,
                        'category_id'       => $model->category_id,
                        'citation_type_id'  => $model->citation_type_id,
                        'author'            => $model->author,
                        'title'             => $model->title,
                        'number_process'    => $model->number_process,
                        'number_researcher' => $model->number_researcher
                        ]);
        }


        //salva materia
        $model->save();

        //acompanhamento de url
        $this->changeStatusUrl($model);

        //tags
        // $deletedRows = NewsTag::where('news_id', $model->id)->delete();

        // if($tags)
        // {
        //     for($i = 0; $i < count($tags); $i++)
        //     {
        //         $newsTag = new NewsTag();
        //         $newsTag->news_id = $model->id;
        //         $newsTag->tag_id = $tags[$i];
        //         $newsTag->save();
        //         if(isset($rsEquals))
        //         {
        //             foreach ($rsEquals as $item) {
        //                 $newsTag = new NewsTag();
        //                 $newsTag->news_id = $item->id;
        //                 $newsTag->tag_id = $tags[$i];
        //                 $newsTag->save();
        //             }
        //         }
        //     }
        // }


        //ajuste de imagem
        if($model->image != '')
            $model->image = asset($model->image) . '?' . time();

        //verifica noticias iguais
        $model->equal = $model->where('title', '=', $model->title)->where('news_status_id', '=', 12)->where('url_fapesp', '')->count();

        return $model;

    }

    /**
     * verifica se existe url duplicada
     *
     * @return \Illuminate\Http\Response
     */
    public function urlUnique($url)
    {
        $errors = [];
        $urls = explode("\n", $url);
        if($this->urlsMultipleCheck($urls))
        {
            foreach($urls as $url)
            {
                $like  = explode("://", $url);
                $like  = isset($like[1]) ? '%' . trim($like[1]): $like[0];
                if(News::where('url', 'like', $like)->count())
                {
                    $errors[] = 'URL já cadastrada :: ' . $url;
                }
            }
        }else{
            $like  = explode("://", $url);
            $like  = isset($like[1]) ? '%' . trim($like[1]): $like[0];
            if(News::where('url', 'like', $like)->count())
            {
                $errors[] = 'URL já cadastrada :: ' . $url;
            }
        }

        return $errors;
    }

    /**
     * Salva N noticia iguais de urls diferentes
     *
     * @return \Illuminate\Http\Response
     */
    public function urlsMultipleSave($model, $urls)
    {
        foreach ($urls as $url) {
            $news = clone $model;
            //verifica se existe noticias com mesmo dominio
            $domain     = explode('/', $url);
            if(isset($domain[2]))
            {
                $like    = '%//' . $domain[2] . '%';
                //caso exista atribui noticia ao mesmo veiculo
                if(News::where('url', 'like', $like)->count() > 0)
                {
                    $news->vehicle_id = News::where('url', 'like', $like)->orderBy('id', 'DESC')->first()->vehicle_id;
                //cria novo veiculo
                }else{
                    $vehicle                    = new Vehicle();
                    $vehicle->description       = $domain[2];
                    $vehicle->media_type_id     = 1;
                    $vehicle->status_vehicle_id = 2;
                    $vehicle->url               = $domain[0] . '//' . $domain[2];
                    $vehicle->save();
                    $news->vehicle_id = $vehicle->id;
                }
                $news->url = $url;
                $news->save();
                //acompanhamento de url
                $this->changeStatusUrl($news);
                $ids[] = $news->id;
            }
        }
        return array('ids' => implode('-', $ids));
    }

    /**
     *verifica multiplas url's
     */
    private function urlsMultipleCheck($urls)
    {
        $aux = [];
        foreach ($urls as $url) {
            if(strlen(trim($url)) > 0)
            {
                $aux[] = $url;
            }
        }
        return count($aux) > 1;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function equals(Request $request)
    {
        $model = News::findOrFail($request->input('id'));
        $model->where('title', '=', $model->title)->where('news_status_id', '=', 12)->update(['url_fapesp' => $model->url_fapesp]);

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
        if($request->hasFile('image') && $image->isValid())
        {
            $fileInfo  = pathinfo($image->getClientOriginalName());
            $extension = $fileInfo['extension'];
            $fileName  = 'news.' . $extension;

            $upload    = $image->storeAs($this->_public_path.'/news', $fileName);
            $image     = str_replace($this->_public_path, $this->_uploads_path, $upload);
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

        if($request->input('id') > 0)
        {
            $model = News::find($request->input('id'));

            if(!is_null($model->image) && file_exists($model->image)) {
                Storage::delete(str_replace($this->_uploads_path, $this->_public_path, $model->image));
            }

            $model->image = '';
            $model->save();
        }else{
            $model = new News();
        }

        return $model;
    }

    public function edit(Request $request)
    {
        $news = new News();

        if(isset($request->id))
        {
            $news = News::find($request->id);
        }else if(isset($request->id_copy))
        {
            $news = News::find($request->id_copy);
            $news->id = null;
        }

		if($news == null)
		{
			$news = new News();
			$news->title = 'Notícia não encontrada no banco de dados';
		}

        if($news->image !== '' && !is_null($news->image) && file_exists(public_path($news->image)))
        {
            $news->image = asset($news->image) . '?' . time();
        }else{
            $news->image = '';
        }
        //tags
        $tags = $news->tags;
        $tags = $tags->toArray();
        $aux  = array();

        for($i = 0; $i < count($tags); $i++)
        {
            $aux[] = $tags[$i]['tag_id'];
        }

        $news->tags = $aux;

        //formata number-process
        $aux = array();
        if($news->number_process)
        {
            $news->number_process = json_decode($news->number_process);
            foreach ($news->number_process as $number) {
                $aux[] = $this->numberProcessFormat($number);
            }
        }
        $news->number_process = $aux;

        //decode number_researcher
        $news->number_researcher = json_decode($news->number_researcher);

        //vehicles
        $rs = Vehicle::selectRaw('vehicles.*, (select count(*) from news where vehicle_id = vehicles.id) total, media_types.description as media')
                        ->join('media_types', 'vehicles.media_type_id', '=', 'media_types.id')
                        ->whereIn('vehicles.status_vehicle_id', array(1, 2))
                        ->orderBy('vehicles.description')
                        ->groupBy('vehicles.id')
                        ->get();

        foreach ($rs as $item) {
            $item->description = $item->description . ' | ' . $item->media . ' | ' . $item->url . ' | (' . $item->total . ' Notícias)';
        }

        $this->data['news']          = $news;
        $this->data['user_id']       = Auth::user()->id;
        $this->data['status']        = NewsStatus::orderBy('description')->get()->toArray();
        $this->data['vehicles']      = $rs;
        $this->data['json_vehicles'] = json_encode($this->data['vehicles']->toArray());
        $this->data['categories']    = Category ::orderBy('description')->get()->toArray();
        $this->data['citations']     = CitationType::orderBy('description')->get()->toArray();
        $this->data['media_types']   = MediaType::orderBy('description')->get()->toArray();
        $this->data['tags']          = Tag::orderBy('type')->orderBy('description')->get()->toArray();

        $this->data['type']          = '';

        return view('admin.newsEdit', $this->data);
    }

    public function multipleEdit(Request $request)
    {
        $ids = explode("-", $request->ids);

        $news = News::whereIn('id', $ids)->orderBy('updated_at', 'DESC')->get();

        foreach ($news as $item) {
            $item->vehicle = $item->vehicle;
            $item->date    = ($item->dt_publication != '' ?  $item->dt_publication->format('d/m') : '');
        }

        $tags = $news[0]->tags;
        $tags = $tags->toArray();
        $aux  = array();

        for($i = 0; $i < count($tags); $i++)
        {
            $aux[] = $tags[$i]['tag_id'];
        }

        $news[0]->tags = $aux;

        //formata number-process
        $aux = array();
        if($news[0]->number_process)
        {
            $news[0]->number_process = json_decode($news[0]->number_process);
            foreach ($news[0]->number_process as $number) {
                $aux[] = $this->numberProcessFormat($number);
            }
        }
        $news[0]->number_process = $aux;

        //decode number_researcher
        $news[0]->number_researcher = json_decode($news[0]->number_researcher);

        $this->data['news']        = $news;
        $this->data['json_news']   = json_encode($news);
        $this->data['status']      = NewsStatus::orderBy('description')->get()->toArray();
        $this->data['categories']  = Category ::orderBy('description')->get()->toArray();
        $this->data['citations']   = CitationType::orderBy('description')->get()->toArray();
        $this->data['tags']        = Tag::orderBy('description')->get()->toArray();
        $this->data['ids']         = $request->ids;
        $this->data['user_id']     = Auth::user()->id;

        return view('admin.newsEditMultiple', $this->data);
    }

    public function multipleSave(Request $request)
    {
        $ids  = explode('-', $request->input('ids'));
        $tags = explode(',', $request->input('tags'));

         $data = [
                    'title'             => $request->input('title'),
                    'text'              => $request->input('text'),
                    'news_status_id'    => $request->input('news_status_id'),
                    'category_id'       => $request->input('category_id'),
                    'citation_type_id'  => $request->input('citation_type_id'),
                    'author'            => $request->input('author'),
                    'url_fapesp'        => $request->input('url_fapesp'),
                    'user_id'           => $request->input('user_id'),
                    'multiple'          => 1,
                    'number_process'    => (strlen($request->input('number_process')) > 0 ? json_encode(explode(',', $request->input('number_process'))): ''),
                    'number_researcher' => (strlen($request->input('number_researcher')) > 0 ? json_encode(explode(',', $request->input('number_researcher'))): '')
                ];

        $rs          = News::whereIn('id', $ids)->update($data);

        $deletedRows = NewsTag::whereIn('news_id', $ids)->delete();

        for($i = 0; $i < count($tags); $i++)
        {
            for($j = 0; $j < count($ids); $j++ )
            {
                $newsTag = new NewsTag();
                $newsTag->news_id = $ids[$j];
                $newsTag->tag_id = $tags[$i];
                $newsTag->save();
            }
        }

        return $rs;
    }

    public function list(Request $request)
    {
        $rs = News::query();

        if(isset($request->vehicle_id) && $request->vehicle_id > 0)
            $rs->where('vehicle_id', $request->vehicle_id);
        else
            $request->vehicle_id = 0;

        if(isset($request->type_vehicle) && $request->type_vehicle > 0)
        {
            $rs->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id');
            switch ($request->type_vehicle) {
                case 1:
                    $rs->where('vehicles.country_id', '=' , 1);
                    break;
                case 2:
                    $rs->where('vehicles.country_id', '<>' , 1);
                    break;
                case 3:
                    $rs->where('vehicles.big', '=' , 1);
                    break;
            }
        }

        if(isset($request->category_id) && $request->category_id > 0)
            $rs->where('category_id', $request->category_id);
        else
            $request->category_id = 0;


        if(isset($request->status_id) && $request->status_id > 0)
            $rs->where('news_status_id', $request->status_id);
        else
            $request->status_id = 0;

        if(isset($request->daterange) && $request->daterange != '')
        {
            $dates = explode(',', $request->daterange);
            $rs->where('dt_publication', '>=', $dates[0])
                ->where('dt_publication', '<=', $dates[1]);
        }else {
            $request->daterange = '';
        }

        if(isset($request->key) && $request->key != '')
        {
            if((int) $request->key > 0)
            {
                $rs->where('id', $request->key);
            }else if(filter_var($request->key, FILTER_VALIDATE_URL))
            {
                $rs->where(function ($query) use ($request)
                {
                    $url = explode('//', $request->key);
                    $url = isset($url[1]) ? '%' . trim($url[1]) : $url[0];
                    $query->where('news.url_fapesp', 'like', $url)
                        ->orWhere('news.url', 'like', $url);
                    });
            }else{
                // $search_txt = explode(' ', $request->$keys);
                // for ($i=0; $i < count($search_txt); $i++) {
                //     $search_txt[$i] = '+' . $search_txt[$i];
                // }
                // $search_txt = implode(' ', $search_txt);
                // $rs->selectRaw("*, MATCH(title, text, summary, url)AGAINST('" . addslashes($request->key) . "') relevance");
                // $rs->whereRaw("MATCH(title, text, summary, url)AGAINST('" . addslashes($search_txt) . "' IN BOOLEAN MODE)");
                // $rs->orderByRaw('relevance DESC');
                $key = '%' . addslashes($request->key) . '%';
                $rs->where(function($query) use ($key)
                {
                    $query->where('title', 'like', $key)
                        ->orWhere('text', 'like', $key)
                        ->orWhere('summary', 'like', $key);
                });
            }
        }else{
            $request->key = '';
        }

        $rs->orderBy('dt_publication', 'desc');
        $rs = $rs->paginate(25);

        foreach ($rs as $item)
        {
            $item->vehicle    = $item->vehicle;
            $item->category   = $item->category;
            $item->lang       = $item->lang;
            $item->mediaType  = $item->mediaType;
            $item->status     = $item->status;
            $item->date       = isset($item->dt_publication) ? $item->dt_publication->format('d/m/Y') : ' - ';
            //from
            $from = '';
            if($item->vehicle)
            {
                $country = $item->vehicle->country;
                if(isset($country))
                {
                    if($country->id == 1)
                        $from = $country->description . ' | ' . $item->vehicle->state . " | " . $item->vehicle->city;
                    else
                        $from = $country->description;
                }
            }

            //local de origem do veiculo
            $item->from = $from;
        }
        $lastPage             = $rs->lastPage();
        $currentPage          = $rs->currentPage();

        $return               = array();
        $return['rs']         = $rs;
        $return['rangePages'] = $this->rangePages($lastPage, $currentPage);
        $return['rangePages'] = (object) $return['rangePages'];
        $return               = (object) $return;

        return \Response::json($return);
    }

    public function allComboBox()
    {
        $status               = NewsStatus::orderBy('description')->get();
        $categories           = Category::orderBy('description')->get();
        $vehicles             = Vehicle::selectRaw('vehicles.*, (select count(*) from news where vehicle_id = vehicles.id) total, media_types.description as media')
                                ->join('media_types', 'vehicles.media_type_id', '=', 'media_types.id')
                                ->whereIn('vehicles.status_vehicle_id', array(1, 2))
                                ->orderBy('vehicles.description')
                                ->groupBy('vehicles.id')
                                ->get();

        foreach ($vehicles as $item) {
            $item->description = $item->description . ' | ' . $item->media . ' | (' . $item->total . ' Notícias)';
        }

        $return               = array();
        $return['status']     = $status;
        $return['vehicles']   = $vehicles;
        $return['categories'] = $categories;
        $return               = (object) $return;

        return \Response::json($return);

    }

    public function delete(Request $request)
    {
        $ids = explode('-', $request->input('id'));
        $deletedRows = News::whereIn('id', $ids)->delete();

        return $deletedRows;
    }

    private function changeStatusUrl($news)
    {
        //acompanhamento de url
        $url    = explode('//', $news->url);
        $url    = isset($url[1]) ? '%' . trim($url[1]): $url[0];
        if(Url::where('url', 'like', $url)->count())
        {
            $url = Url::where('url', 'like', $url)->first();
            $url->register = '1';
            $url->save();
        }
    }


}
