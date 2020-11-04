<?php

namespace App\Http\Controllers;

use JWTHelper;
use App\Model\News;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class SitemapController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $pages = News::selectRaw('id, title as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->orderBy('dt_publication', 'DESC')
                    ->paginate(1000)
                    ->lastPage();
        $this->data['pagesNews'] = $pages;
        return response()->view('site.sitemap', $this->data)->header('Content-Type', 'text/xml');
    }

    public function internals(Request $request)
    {
        $getUrl  = null;
        $baseUrl = null;
        $rawUrl  = null;

        switch ($request->slug) {
            case 'news':
                $pages    = News::selectRaw('id, title as name, dt_publication')
                    ->whereIn('news_status_id', News::statusActive())
                    ->orderBy('dt_publication');

                //set pagina atual
                Paginator::currentPageResolver(function () use ($request) {
                    $request->pg = (int) $request->pg;
                    return $request->pg;
                });

                $pages = $pages->paginate(1000);
                $changes  = 'weekly';
                $priority = 1.0;
                break;

            case 'news-brazil':
                $pages    = News::selectRaw('news.id, news.title as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
                    ->where('vehicles.country_id', 1)
                    ->orderBy('dt_publication', 'DESC')
                    ->limit(10000)
                    ->get();

                $changes  = 'weekly';
                $priority = 0.9;
                break;

            case 'news-world':
                $pages    = News::selectRaw('news.id, news.title as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
                    ->where('vehicles.country_id', '<>', 1)
                    ->orderBy('dt_publication', 'DESC')
                    ->limit(10000)
                    ->get();

                $changes  = 'weekly';
                $priority = 0.7;
                break;

            case 'news-country':
                $pages    = News::selectRaw('countries.id as id, countries.description as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
                    ->join('countries', 'countries.id', '=', 'vehicles.country_id')
                    ->groupBy('vehicles.country_id')
                    ->orderBy('countries.description', 'ASC')
                    ->get();

                $baseUrl = 'paises';
                $changes  = 'weekly';
                $priority = 0.5;
                break;

            case 'news-years':
                $pages    = News::selectRaw('YEAR(dt_publication) as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->groupBy(DB::raw('YEAR(dt_publication)'))
                    ->orderBy('dt_publication', 'DESC')
                    ->get();

                $baseUrl  = 'pesquisa';
                $getUrl   = '?y=';
                $changes  = 'weekly';
                $priority = 0.5;
                break;

            case 'vehicles-brazil':
                $pages    = News::selectRaw('vehicles.id, vehicles.description as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
                    ->where('vehicles.country_id', 1)
                    ->groupBy('vehicles.id')
                    ->orderBy('vehicles.description', 'ASC')
                    ->get();

                $rawUrl   = 'veiculos';
                $changes  = 'weekly';
                $priority = 0.9;
                break;

            case 'vehicles-world':
                $pages    = News::selectRaw('vehicles.id, vehicles.description as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
                    ->where('vehicles.country_id', '<>', 1)
                    ->groupBy('vehicles.id')
                    ->orderBy('vehicles.description', 'ASC')
                    ->get();

                $rawUrl   = 'veiculos-internacionais';
                $changes  = 'weekly';
                $priority = 0.6;
                break;

            case 'plataforms':
                $pages    = News::selectRaw('media_types.id as name')
                    ->whereIn('news_status_id', News::statusActive())
                    ->join('media_types', 'news.media_type_id', '=', 'media_types.id')
                    ->groupBy('media_types.id')
                    ->orderBy('media_types.description')
                    ->get();

                $baseUrl  = 'pesquisa';
                $getUrl   = '?m=';
                $changes  = 'weekly';
                $priority = 0.5;
                break;
        }

        return response()->view('site.sitemap', [
            'internal' => 1,
            'slug'     => $baseUrl,
            'gets'     => $getUrl,
            'raw'      => $rawUrl,
            'pages'    => $pages,
            'changes'  => $changes,
            'priority' => $priority,
            'request'  => $request
        ])->header('Content-Type', 'text/xml');
    }
}
