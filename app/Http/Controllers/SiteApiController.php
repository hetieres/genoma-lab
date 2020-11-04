<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class SiteApiController extends Controller
{

    /**
     * home.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNewsFeatured($featured)
    {
        $error     = 0;
        $return    = (object) [];

        $highlight = News::where('id',  $featured)->first();

        if(is_null($highlight))
            return ['error' => 'ID inválido', 'highlight' => $return];

        $reference             = '{"url": "' . $highlight->url_fapesp . '", "date": "' . $highlight->dt_publication->format('Y-m-d') . '", "type": "", "highlight": true}';
        $return->ref           = base64_encode($reference);
        $return->date          = $highlight->dt_publication->formatLocalized('%d de %B de %Y');
        $return->id            = $highlight->id;
        $return->caption_image = $highlight->caption_image;
        $return->title         = $highlight->title;
        $return->url           = $highlight->url_fapesp;
        $return->link          = str_slug($highlight->title) . '/' . $highlight->id;
        $return->text          = $highlight->summary != '' ? $highlight->summary : \App\Helpers\BaseHelper::limitChar(str_replace(["\n","\r","\t"], " ", strip_tags($highlight->text)), 280);
        $return->vhNew         = [];
        $return->vhOld         = [];

        $imagePath = (!is_null($highlight->image) ? str_replace('files', '', $highlight->image) : '');

        if(Storage::exists('public' . $imagePath)) $image = asset($highlight->image);
        else $image = asset("assets/img/no-image-news.jpg");

        $return->image         = $image;

        return ['error' => $error, 'highlight' => $return];
    }

    public function getNews(Request $request, $type=null)
    {
        $error         = 0;
        $return        = [];
        $international = (!is_null($type) ? (int) $type : 0);

        $dateSql = News::selectRaw('news.dt_publication');
        $dateSql->where('news.url_fapesp', '<>', '');
        $dateSql->where('news.url_fapesp', '<>', $request->featured);
        $dateSql->whereIn('news.news_status_id', News::statusActive());
        $dateSql->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id');
        $dateSql->groupBy('news.dt_publication');

        // Verifica Internacional
        $this->_getInternational($dateSql, $type);

        $dateData = $dateSql->orderBy('news.dt_publication', 'DESC')->paginate(5);

        $dates = [];
        foreach ($dateData as $item) {
            $dates[] = $item->dt_publication;
        }

        // $newsSql = News::selectRaw('news.id, replace(replace(news.url_fapesp, \'https://\', \'\'), \'http://\', \'\') as url_fapesp, MAX(news.dt_publication) AS dt_publication, news.title, news.text');
        // $newsSql->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id');
        // $newsSql->where('news.url_fapesp', '<>', '');
        // $newsSql->where('news.url_fapesp', '<>', $request->featured);
        // $newsSql->whereIn('news.dt_publication', $dates);
        // $newsSql->whereIn('news.news_status_id', News::statusActive());

        // $this->_getInternational($newsSql, $type);

        // $newsSql->groupBy(DB::raw('replace(replace(news.url_fapesp, \'https://\', \'\'), \'http://\', \'\')'));
        // $newsData = $newsSql->orderBy('dt_publication', 'DESC')->orderBy('vehicles.big', 'DESC')->get();

        $table = "view_news_group";
        switch ($type) {
            case 1:
                $table = $table . '_national';
                break;

            case 2:
                $table = $table . '_international';
                break;
        }
        $request->featured = explode('://', $request->featured);
        $request->featured = isset($request->featured[1]) ? $request->featured[1]: $request->featured[0];
        $newsData          = DB::table($table)
                                ->whereIn('dt_publication', $dates)
                                ->where('url_fapesp', '<>', $request->featured)
                                ->orderBy('dt_publication', 'DESC')
                                ->get();

        $newsDate = '';
        $newsUrl  = '';
        $i        = 0;
        foreach ($newsData as $news) {
            $news->dt_publication = Carbon::parse($news->dt_publication);
            $date                 = $news->dt_publication->formatLocalized('%d de %B de %Y');
            $dateBase             = $news->dt_publication->format('Y-m-d');

            if ($newsDate !== $dateBase) {
                $item          = (object) [];
                $item->date    = $date;
                $item->dateRaw = $dateBase;
                $item->news    = [];

                $newsDate      = $dateBase;
                $i++;
            }

            if ($newsUrl !== $news->url_fapesp) {
                $ref   = '{"url": "' . $news->url_fapesp . '", "date": "' . $dateBase . '", "type": "' . $international . '"}';
                $infos = (object) [
                    'ref'   => base64_encode($ref),
                    'id'    => $news->id,
                    'url'   => $news->url_fapesp,
                    'link'  => str_slug($news->title) . '/' . $news->id,
                    'title' => $news->title,
                    'text'  => \App\Helpers\BaseHelper::limitChar(str_replace(["\n","\r","\t"], " ", strip_tags($news->text)), 280),
                    'vhNew' => [],
                    'vhOld' => []
                ];

                $item->news[]     = $infos;
                $newsUrl          = $news->url_fapesp;
            }

            $return[($i-1)] = $item;
        }

        return ['error' => $error, 'news' => $return];
    }

    public function getNewsVehicles(Request $request)
    {
        $error    = 0;
        $return   = (object) ['old' => [], 'new' => []];
        $data     = json_decode(base64_decode($request->ref));

        if(!isset($data->url) || trim($data->url) == ''){
            return ['error' => 'Parâmetros Inválidos', 'vehicles' => null];
        }

        //ajuste url aceita http ou https
        // $data->url = explode('//', $data->url);
        // $data->url = isset($data->url[1]) ? '%' . trim($data->url[1]) : $data->url[0];
        $data->url = '%' . trim($data->url);

        $newsSql  = News::selectRaw('news.id, vehicles.description as name, news.dt_publication, news.title');
        $newsSql->where('news.url_fapesp', 'like', $data->url);
        $newsSql->where('news.url_fapesp', '<>', '');
        $newsSql->whereIn('news.news_status_id', News::statusActive());
        $newsSql->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id');
        if(!isset($data->highlight))
            $newsSql->where('news.dt_publication', '<=', $data->date);

        $this->_getInternational($newsSql, $data->type);

        $newsSql->groupBy('vehicles.id');
        $newsData = $newsSql->orderBy('vehicles.big', 'DESC')->orderBy('news.dt_publication', 'DESC')->get();

        foreach ($newsData as $news) {
            $item = (object) [
                'name' => $news->name,
                'link' => str_slug($news->title) . '/' . $news->id
            ];
            if ($news->dt_publication->format('Y-m-d') === $data->date) {
                $return->new[] = $item;
            } else {
                $return->old[] = $item;
            }
        }

        return ['error' => $error, 'vehicles' => $return];
    }

    private function _getInternational($sql, $type=null)
    {
        switch ($type) {
            case 1:
                $sql->where('vehicles.country_id', '=', 1);
                break;

            case 2:
                $sql->where('vehicles.country_id', '<>', 1);
                break;
        }
    }
}
