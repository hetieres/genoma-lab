<?php

namespace App\Http\Controllers;

use App\Model\News;
use App\Model\Country;
use App\Model\Vehicle;
use App\Model\Category;
use App\Model\MediaType;
use App\Model\NewsStatus;
use App\Model\CitationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $vehicles = Vehicle::selectRaw('vehicles.*, (select count(*) from news where vehicle_id = vehicles.id) total, media_types.description as media')
            ->join('media_types', 'vehicles.media_type_id', '=', 'media_types.id')
            ->whereIn('vehicles.status_vehicle_id', array(1, 2))
            ->orderBy('vehicles.description')
            ->groupBy('vehicles.id')
            ->get();

        foreach ($vehicles as $item) {
            $item->description = $item->description . ' | ' . $item->media . ' | (' . $item->total . ' Notícias)';
        }

        $this->data['vehicles']   = $vehicles;
        $this->data['status']     = NewsStatus::orderBy('description')->get();
        $this->data['media']      = MediaType::orderBy('description')->get();
        $this->data['citations']  = CitationType::orderBy('description')->get();
        $this->data['categories'] = Category::orderBy('description')->get();

        return view('admin.newsReport', $this->data);
    }

    public function reportNews(Request $request)
    {
        set_time_limit(0);

        $month = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        //noticias por categoria
        $rs = News::query();
        $rs = $rs->selectRaw('count(*) as y, categories.description as name, categories.description as drilldown')
                ->join('categories', 'categories.id', '=', 'news.category_id')
                ->groupBy('categories.description')
                ->orderBy('categories.description');
        $filter = $this->filters($rs, $request);
        $rs = $rs->get();

        $aux           = array();
        $aux['title']  = 'Notícias x Categoria';
        $aux['type']   = 'Categoria';
        $aux['filter'] = $filter['filter'];
        $aux['data']   = $rs;//$aux;
        $json[]        = $aux;

        //noticias por midia
        $rs = News::query();
        $rs = $rs->selectRaw('count(*) as y, media_types.description as name, media_types.description as drilldown')
                ->join('media_types', 'media_types.id', '=', 'news.media_type_id')
                ->groupBy('media_types.description')
                ->orderBy('media_types.description');
        $filter = $this->filters($rs, $request);
        $rs = $rs->get();

        $aux           = array();
        $aux['title']  = 'Notícias x Mídia';
        $aux['type']   = 'Tipo de mídia';
        $aux['filter'] = $filter['filter'];
        $aux['data']   = $rs;//$aux;
        $json[]        = $aux;

        //noticias por assunto mais repercutidos
        $rs = News::query();
        $rs = $rs->selectRaw('title, count(*) as total')
                ->groupBy('title')
                ->orderBy('total', 'DESC');
        $filter = $this->filters($rs, $request);
        $rs = $rs->limit($request->limit)->get();

        $aux           = array();
        $aux['filter'] = $filter['filter'];
        $aux['data']   = $rs;//$aux;
        $json[]        = $aux;

        //noticias por url Fapesp
        $rs = News::query();
        $rs = $rs->selectRaw('title, url_fapesp, count(*) as total')
                ->where('url_fapesp', '<>', '')
                ->groupBy('url_fapesp')
                ->orderBy('total', 'DESC');
        $filter = $this->filters($rs, $request);
        $rs = $rs->limit($request->limit)->get();

        $aux           = array();
        $aux['filter'] = $filter['filter'];
        $aux['data']   = $rs;//$aux;
        $json[]         = $aux;



        //noticias
        $rs = News::query();
        if(isset($request->key) && trim($request->key) != '' && !filter_var($request->key, FILTER_VALIDATE_URL)){
            $rs->selectRaw("*, MATCH(news.title, news.text, news.summary, news.url)AGAINST('" . addslashes($request->key) . "') relevance");
            //$rs->whereRaw("MATCH(title, text, summary, url)AGAINST('" . addslashes($request->key) . "' IN BOOLEAN MODE)");
            //$request->key = '';
            $filter = $this->filters($rs, $request);
            $rs = $rs->orderByRaw('relevance DESC')->limit($request->limit)->get();
        }else{
            $filter = $this->filters($rs, $request);
            $rs = $rs->orderBy('dt_publication', 'DESC')->limit($request->limit)->get();
        }

        foreach ($rs as $item)
        {
            $item->vehicle    = $item->vehicle;
            $item->mediaType  = MediaType::find($item->vehicle->media_type_id);
            $item->date       = isset($item->dt_publication) ? $item->dt_publication->format('d/m/Y') : ' - ';
            $item->url        = $item->url . '<br>' . route('detalhe', ['title' => str_slug($item->title), 'id' => $item->id]) . '<br>' . $item->url_fapesp;
            $item->from       = '';
            $country          = Country::find($item->vehicle->country_id);
            if(isset($country)){
                if($country->id == 1)
                    $item->from = $country->description . ' | ' . $item->state . " | " . $item->city;
                else
                    $item->from = $country->description;
            }
        }
        $aux           = array();
        $aux['filter'] = $filter['filter'];
        $aux['url']    = $filter['url'];
        $aux['data']   = $rs;//$aux;
        //total
        $rs = News::query();
        $rs = $rs->selectRaw('count(*) as total');
        $filter = $this->filters($rs, $request);
        $rs = $rs->get();
        $aux['total']  = $rs[0]->total;
        $json[]         = $aux;



        //comparação entre periodos
        if($request->period && $request->period != ''){
            $aux = explode(',', $request->period);
            $p1 = $aux[0];
            $p2 = $aux[1];
            //periodo 1
            $rs1 = News::query();
            $rs1 = $rs1->selectRaw('year(news.dt_publication) y,
                                    month(news.dt_publication) m,
                                    CAST(concat(month(news.dt_publication), \'/\', year(news.dt_publication))as char) as month, count(*) total,
                                    CONCAT(DATE_FORMAT(\'' . $p1 . '\', \'%d/%m/%Y\'), \' - \', DATE_FORMAT(\'' . $p2 . '\', \'%d/%m/%Y\')) as p1,
                                    CONCAT(DATE_FORMAT(DATE_SUB(\'' . $p1 . '\', INTERVAL 365 DAY), \'%d/%m/%Y\'), \' - \', DATE_FORMAT(DATE_SUB(\'' . $p2 . '\', INTERVAL 365 DAY), \'%d/%m/%Y\')) as p2')
                            ->whereRaw('news.dt_publication >= \'' . $p1 . '\'')
                            ->whereRaw('news.dt_publication <= \'' . $p2 . '\'');
            $filter = $this->filters($rs1, $request, false);
            $rs1 = $rs1->groupBy(DB::raw('concat(year(news.dt_publication), \'/\', month(news.dt_publication))'))
                    ->orderBy('y')
                    ->orderBy('m')
                    // ->toSql();
                    ->get();

            //periodo 2
            $rs2 = News::query();
            $rs2 = $rs2->selectRaw('year(news.dt_publication) y, month(news.dt_publication) m, CAST(concat(month(news.dt_publication), \'/\', year(news.dt_publication))as char) as month, count(*) total')
                                    ->whereRaw('news.dt_publication >= DATE_SUB(DATE_FORMAT(\'' . $p1 . '\', \'%Y-%m-%d\'), INTERVAL 365 DAY)')
                                    ->whereRaw('news.dt_publication <= DATE_SUB(DATE_FORMAT(\'' . $p2 . '\', \'%Y-%m-%d\'), INTERVAL 365 DAY)');
            $filter = $this->filters($rs2, $request, false);
            $rs2 = $rs2->groupBy(DB::raw('concat(year(news.dt_publication), \'/\', month(news.dt_publication))'))
                    ->orderBy('y')
                    ->orderBy('m')
                    // ->toSql();
                    ->get();
            // dd($rs1, $rs2);

        }else{
            //periodo 1
            $rs1 = News::query();
            $rs1 = $rs1->selectRaw('year(news.dt_publication) y,
                                    month(news.dt_publication) m,
                                    CAST(concat(month(news.dt_publication), \'/\', year(news.dt_publication))as char) as month, count(*) total,
                                    CONCAT(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 365 DAY), \'%d/%m/%Y\'), \' - \', DATE_FORMAT(NOW(), \'%d/%m/%Y\')) as p1,
                                    CONCAT(DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 730 DAY), \'%d/%m/%Y\'), \' - \', DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 365 DAY), \'%d/%m/%Y\')) as p2')
                    ->whereRaw('news.dt_publication >= DATE_SUB(DATE_FORMAT(NOW(), \'%Y-%m-%d\'), INTERVAL 365 DAY)');
            $filter = $this->filters($rs1, $request, false);
            $rs1 = $rs1->groupBy(DB::raw('concat(year(news.dt_publication), \'/\', month(news.dt_publication))'))
                    ->orderBy('y')
                    ->orderBy('m')
                    ->get();

            //periodo 2
            $rs2 = News::query();
            $rs2 = $rs2->selectRaw('year(news.dt_publication) y, month(news.dt_publication) m, CAST(concat(month(news.dt_publication), \'/\', year(news.dt_publication))as char) as month, count(*) total')
                                    ->whereRaw('news.dt_publication >= DATE_SUB(DATE_FORMAT(NOW(), \'%Y-%m-%d\'), INTERVAL 730 DAY)')
                                    ->whereRaw('news.dt_publication < DATE_SUB(DATE_FORMAT(NOW(), \'%Y-%m-%d\'), INTERVAL 365 DAY)');
            $filter = $this->filters($rs2, $request, false);
            $rs2 = $rs2->groupBy(DB::raw('concat(year(news.dt_publication), \'/\', month(news.dt_publication))'))
                    ->orderBy('y')
                    ->orderBy('m')
                    ->get();
        }

        $obj1 = (object)[];
        $obj2 = (object)[];
        if(isset($rs1[0])){
            $obj1->name = $rs1[0]->p1;
            $obj2->name = $rs1[0]->p2;
        }else{
            $obj1->name = '';
            $obj2->name = '';
        }
        $obj1->data = array();
        $obj2->data = array();

        $months = array();

        if(count($rs1) >= count($rs2)) {
            for ($i=0; $i < count($rs1); $i++) {
                $flag = false;
                for ($j=0; $j < count($rs2); $j++) {
                    if ($rs1[$i]->y == ($rs2[$j]->y + 1) && $rs1[$i]->m == $rs2[$j]->m) {
                        $months[] = $month[$rs1[$i]->m - 1];
                        $obj1->data[] = $rs1[$i]->total;
                        $obj2->data[] = $rs2[$j]->total;
                        $flag = true;
                    }
                }
                if(!$flag){
                    $months[] = $month[$rs1[$i]->m - 1];
                    $obj1->data[] = $rs1[$i]->total;
                    $obj2->data[] = 0;
                }
            }
        } else {
            for ($i=0; $i < count($rs2); $i++) {
                $flag = false;
                for ($j=0; $j < count($rs1); $j++) {
                    if ($rs2[$i]->y == ($rs1[$j]->y + 1) && $rs2[$i]->m == $rs1[$j]->m) {
                        $months[] = $month[$rs2[$i]->m - 1];
                        $obj1->data[] = $rs2[$i]->total;
                        $obj2->data[] = $rs1[$j]->total;
                        $flag = true;
                    }
                }
                if(!$flag){
                    $months[] = $month[$rs2[$i]->m - 1];
                    $obj1->data[] = 0;
                    $obj2->data[] = $rs2[$i]->total;
                }
            }
        }

        $aux = array();
        $aux['series'] = [$obj1, $obj2];
        $aux['months'] = $months;
        $aux['filter'] = $filter['filter'];

        $json[] = $aux;


        //repercussão por veículo
        $rs = News::query();
        $rs = $rs->selectRaw('vehicles.*, countries.description as country, media_types.description as media_type, count(*) total')
                ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
                ->join('media_types', 'media_types.id', '=', 'vehicles.media_type_id')
                ->join('countries', 'countries.id', '=', 'vehicles.country_id')
                ->groupBy('vehicles.id')
                ->orderBy('total', 'DESC')
                ->limit($request->limit);
        $filter = $this->filters($rs, $request);
        $rs = $rs->get();

        $aux           = array();
        $aux['filter'] = $filter['filter'];
        $aux['data']   = $rs;//$aux;
        $json[]         = $aux;


        return \Response::json($json);
    }

    public function filters($rs, $request, $period = true)
    {
        $filter = "";
        $url = "";

        if(isset($request->category_id) && $request->category_id != ''){
            $url .= strlen($url) ? '&' : '';
            $url .= 'category_id=' . $request->category_id;
            $aux = explode(',', $request->category_id);
            $rs->whereIn('news.category_id', $aux);
            $aux = Category::selectRaw('GROUP_CONCAT(description SEPARATOR \', \') as filter')->whereIn('id', $aux)->get();
            $filter .= "<br>Categoria(s): " . $aux[0]->filter;
        }

        if(isset($request->news_status_id) && $request->news_status_id != ''){
            $url = strlen($url) ? '&' : '';
            $url = 'news_status_id=' . $request->news_status_id;
            $aux = explode(',', $request->news_status_id);
            $rs->whereIn('news.news_status_id', $aux);
            $aux = NewsStatus::selectRaw('GROUP_CONCAT(description SEPARATOR \', \') as filter')->whereIn('id', $aux)->get();
            $filter .= "<br>Status: " . $aux[0]->filter;
        }

        if(isset($request->media_type_id) && $request->media_type_id != ''){
            $url .= strlen($url) ? '&' : '';
            $url .= 'media_type_id=' . $request->media_type_id;
            $aux = explode(',', $request->media_type_id);
            $rs->whereIn('news.media_type_id', $aux);
            $aux = MediaType::selectRaw('GROUP_CONCAT(description SEPARATOR \', \') as filter')->whereIn('id', $aux)->get();
            $filter .= "<br>Midía(s): " . $aux[0]->filter;
        }

        if(isset($request->citation_type_id) && $request->citation_type_id != ''){
            $url .= strlen($url) ? '&' : '';
            $url .= 'citation_type_id=' . $request->citation_type_id;
            $aux = explode(',', $request->citation_type_id);
            $rs->whereIn('news.citation_type_id', $aux);
            $aux = CitationType::selectRaw('GROUP_CONCAT(description SEPARATOR \', \') as filter')->whereIn('id', $aux)->get();
            $filter .= "<br>Tipo de citação(s): " . $aux[0]->filter;
        }

        if(isset($request->vehicle_type) && $request->vehicle_type > 0){
            $url = strlen($url) ? '&' : '';
            $url = 'vehicle_type=' . $request->vehicle_type;
            if(!$this->isJoined($rs, 'vehicles')){
                $rs->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id');
            }
            switch ($request->vehicle_type) {
                case 1:
                    $rs->where('vehicles.country_id', '=' , 1);
                    $filter .= "<br>Veículos Nacionais";
                    break;
                case 2:
                    $rs->where('vehicles.country_id', '<>' , 1);
                    $filter .= "<br>Veículos Internacionais";
                    break;
                case 3:
                    $rs->where('vehicles.big', '=' , 1);
                    $filter .= "<br>Veículos - Grande Empresa";
                    break;
            }
        }

        if(isset($request->vehicle_id) && $request->vehicle_id != ''){
            $url .= strlen($url) ? '&' : '';
            $url .= 'vehicle_id=' . $request->vehicle_id;
            $aux = explode(',', $request->vehicle_id);
            $rs->whereIn('news.vehicle_id', $aux);
            $aux = Vehicle::selectRaw('GROUP_CONCAT(description SEPARATOR \', \') as filter')->whereIn('id', $aux)->get();
            $filter .= "<br>Veículos(s): " . $aux[0]->filter;
        }

        if(isset($request->period) && $request->period != '' && $period){
            $url .= strlen($url) ? '&' : '';
            $url .= 'period=' . $request->period;
            $aux = explode(',', $request->period);
            $rs->where('news.dt_publication', '>=', $aux[0]);
            $rs->where('news.dt_publication', '<=', $aux[1]);
            $filter .= "<br>Período: " .  date("d/m/Y", strtotime($aux[0])) . ' a ' .  date("d/m/Y", strtotime($aux[1]));
        }

        if(isset($request->key) && trim($request->key) != ''){
            $url .= strlen($url) ? '&' : '';
            $url .= 'key=' . $request->key;
            if(filter_var($request->key, FILTER_VALIDATE_URL)){
                $rs->where(function ($query) use ($request){
                    $url = explode('//', $request->key);
                    $url = isset($url[1]) ? '%' . trim($url[1]) : $url[0];
                    $query->where('news.url_fapesp', 'like', $url)
                        ->orWhere('news.url', 'like', $url);
                });
                $filter .= "<br>URL: " .  $request->key;
            }else{
                $rs->whereRaw("MATCH (news.title, news.text, news.summary, news.url) AGAINST ('" . addslashes($request->key) . "' IN BOOLEAN MODE)");
                $filter .= "<br>Palavra chave: " .  $request->key;
            }
        }

        return ['filter' => $filter, 'url' => $url];
    }

    public function download(Request $request)
    {
        //noticias
        $rs     = News::query();
        $filter = $this->filters($rs, $request);
        $rs     = $rs->orderBy('dt_publication', 'DESC')->limit($request->limit)->get();

        foreach ($rs as $item)
        {
            $item->vehicle    = $item->vehicle;
            $item->mediaType  = MediaType::find($item->vehicle->media_type_id);
            $item->date       = isset($item->dt_publication) ? $item->dt_publication->format('d/m/Y') : ' - ';
            $item->from       = '';
            $country          = Country::find($item->vehicle->country_id);
            if(isset($country)){
                if($country->id == 1)
                $item->from = $country->description . ' | ' . $item->state . " | " . $item->city;
                else
                $item->from = $country->description;
            }
        }

        $this->data['filter'] = $filter['filter'];
        $this->data['url']    = $filter['url'];
        $this->data['data']   = $rs;

        //total
        $rs = News::query();
        $rs = $rs->selectRaw('count(*) as total');
        $filter = $this->filters($rs, $request);
        $rs = $rs->get();
        $this->data['total']  = $rs[0]->total;

         header('Content-type: application/excel');
         header('Content-Disposition: attachment; filename=Lista_Notícias.xls');
         header("Pragma: ");
         header("Cache-Control: ");
         return view('admin.newsReportList', $this->data);

    }


    //testa join
    public function isJoined($query, $table)
    {
        $joins = $query->getQuery()->joins;
        if($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }
        return false;
    }
}
