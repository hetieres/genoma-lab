<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use Carbon\Carbon;
use App\Model\News;
use App\Model\Post;
use App\Model\Video;
use App\Model\Country;
use App\Model\Session;
use App\Model\Category;
use App\Model\MediaType;
use App\Helpers\BaseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    private $conteudo;
    public function __construct(Post $conteudo)
    {
        $this->conteudo = $conteudo;
        View::share('footer', Post::find(151)->text);
    }

    /**
     * home
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->asideData();
        return view('site.home', $this->data);
    }

    public function detalhe(Request $request)
    {

        $slug = isset($request->slug) ? $request->slug : false;
        $id   = isset($request->id)   ? $request->id   : false;

        // SLUG conflita com ID
        if ($slug && is_numeric($slug) === true) {
            $id = $slug;
            $slug = false;
        }

        if ($slug == 'projetos-apoiados' && !$id) {
            $post = Post::find(51);
            return view('site.conteudo', ['post' => $post]);
        } else if ($slug == 'en' && !$id) {
            $post = Post::find(294);
            return view('site.conteudo', ['post' => $post]);
        } else if ($slug == 'comunicados' && !$id) {
            $post = Post::find(220);
            return view('site.conteudo', ['post' => $post]);
        }

        if ($id) {
            $post = Post::find($id);

            if ($slug != str_slug($post->title)) {
                return redirect($post->link(), 301);
            }

            if ($post) {

                switch ($post->session_id) {
                    case '1': //Desenvolvimento de Tecnologias
                        $DadosHead = Post::find(20);
                        return view('site.tecnologia', ['post' => $post, 'DadosHead' => $DadosHead]);
                        break;
                    case '2': //Pesquisa
                        $DadosHead = Post::find(19);
                        return view('site.pesquisa', ['post' => $post, 'DadosHead' => $DadosHead]);
                        break;
                    case '3': //Webinars
                        $DadosHead = Post::find(77);
                        return view('site.educacaodifusao', ['post' => $post, 'DadosHead' => $DadosHead]);
                        break;
                    case '4': //Vídeos
                        $DadosHead = Post::find(152);
                        return view('site.midia', ['post' => $post, 'DadosHead' => $DadosHead]);
                        break;
                    case '5': //Conteúdo
                        return view('site.conteudo', ['post' => $post]);
                        break;
                    case '6': //Suplementos de Rápida Implementação

                        $DadosHead = Post::find(23);
                        return view('site.projetospesquisa', ['post' => $post, 'DadosHead' => $DadosHead]);
                        break;
                }
            }
        }
    }

    public function educacaodifusoes(Request $request)
    {
        $this->data['DadosHead'] = Post::find(77);
        $this->data['educacaodifusoes'] = Post::where('session_id', 3)
            ->where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('dt_publication', 'DESC')
            ->get();


        return view('site.educacaodifusoes', $this->data);
    }

    public function projetospesquisa(Request $request)
    {
        $this->data['DadosHead'] = Post::find(23);
        $this->data['projetospesquisas'] = Post::where('session_id', 6)
            ->where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('title', 'ASC')
            ->get();
        return view('site.projetospesquisas', $this->data);
    }


    public function namidia(Request $request)
    {
        $this->data['DadosHead'] = Post::find(23);
        $this->data['namidias'] = Post::where('session_id', 4)
            ->where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('title', 'ASC')
            ->get();
        return view('site.namidia', $this->data);
    }


    
    public function conhecaogenoma(Request $request)
    {
        $this->data['DadosHead'] = Post::find(20);
        $this->data['tecnologias'] = Post::where('session_id', 1)
            ->where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('title', 'ASC')
            ->get();
        return view('site.tecnologias', $this->data);
    }

    public function pesquisas(Request $request)
    {
        
        $dadosNoticas['pesquisas'] = Post::where('session_id', 2)
            ->where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('dt_publication', 'DESC')
            ->get();
        $dadosNoticas['DadosHead'] = Post::find(19);

        return view('site.pesquisas', $dadosNoticas);
    }

    public function videos()
    {
        $this->data['DadosHead'] = Post::find(152);
        $videos = Post::where('session_id', 4)
            ->where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('dt_publication', 'DESC')
            ->get();
        $this->data['videos'] = $videos;
        return view('site.videos', $this->data);
    }

    private function asideData()
    {
        $this->data['pgHome'] = Post::find(17);
        /*Dados para Notícias*/
        $this->data['Noticias'] = Post::where('session_id', 2)
            ->where('active', 1)
            ->where('highlight', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('order')
            ->limit(2)
            ->get();


        /*Dados para Educação e Difusão*/
        $this->data['EducacaoDifusao'] = Post::where('session_id', 3)
            ->where('active', 1)
            ->where('highlight', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->orderBy('order')
            ->limit(3)
            ->get();

        /*Dados para Genoma na Mídia*/
        $this->data['Midia'] = Post::where('session_id', 4)
        ->where('active', 1)
        ->where('highlight', 1)
        ->where('dt_publication', '<=', date('Y-m-d'))
        ->orderBy('order')
        ->limit(2)
        ->get();
        
        /*Dados para Projetos de Pesquisa*/
        $this->data['projetos'] = Post::where('active', 1)
            ->where('dt_publication', '<=', date('Y-m-d'))
            ->where(function ($query) {
                $query->where('session_id', '=', 1)
                    ->orWhere('session_id', '=', 6);
            })
            ->orderByRaw("RAND()")
            ->limit(3)
            ->get();
    }

    public function search(Request $request)
    {

        $rs = Post::where('session_id', '<>', 5);
        $request->k = trim($request->k); //chave
        $request->o = isset($request->o) ? $request->o : 1;

        //chave
        if (isset($request->k) && trim($request->k) != '') {
            $like = '%' . $request->k . '%';
            $rs->where(function ($query) use ($like) {
                $query->where('title', 'like', $like)
                    ->orWhere('text', 'like', $like)
                    ->orWhere('summary', 'like', $like)
                    ->orWhere('keywords', 'like', $like)
                    ->orWhere('caption_image', 'like', $like);
            });
        }

        //order by
        if ($request->o == 1)
            $rs->orderBy('dt_publication', 'DESC');
        else if ($request->o == 2)
            $rs->orderBy('dt_publication');

        //    dd($rs->toSql());

        //set pagina atual
        Paginator::currentPageResolver(function () use ($request) {
            $request->pg = (int) $request->pg;
            return $request->pg;
        });

        //       dd($rs->toSql());

        $rs = $rs->paginate(10);

        $this->data['rs']          = $rs;
        $this->data['rangePages']  = $this->rangePages($rs->lastPage(), $rs->currentPage(), 7);
        $this->data['lastPage']    = $rs->lastPage();
        $this->data['currentPage'] = $rs->currentPage();
        $this->data['url']         = isset($_GET['k']) ? '?k=' . $_GET['k'] : '?k=';
        $this->data['url']         = $this->data['url'] . (isset($_GET['m']) ? '&m=' . $_GET['m'] : '');
        $this->data['url']         = $this->data['url'] . (isset($_GET['y']) ? '&y=' . $_GET['y'] : '');
        $this->data['url']         = $this->data['url'] . (isset($_GET['o']) ? '&o=' . $_GET['o'] : '');
        $this->data['url']         = $this->data['url'] . (isset($_GET['c']) ? '&c=' . $_GET['c'] : '');
        $this->data['url']         = $this->data['url'] . (isset($_GET['p']) ? '&p=' . $_GET['p'] : '');
        $this->data['url']         = $this->data['url'] . '&pg=';

        return view('site.search', $this->data);
    }


    /*
    *
    * Detalhe noticia/vehicle
    *
    */
    public function detail(Request $request)
    {
        $news = Post::find($request->id);

        //url sem titulo somente id
        if (!isset($request->title)) {
            if ($news == null) {
                return redirect(route('home'));
            } else {
                return redirect(route('details', ['title' => str_slug($news->title), 'id' => $news->id]));
            }
        }


        //se existe noticia
        if (!is_null($news) && str_slug($news->title) === $request->title) {
            $this->newsDetail($news);
            return view('site.news', $this->data);
        } else {
            $vehicle = Vehicle::find($request->id);
            //detalhe do veiculo
            if ($vehicle && str_slug($vehicle->description) === $request->title) {
                $this->vehicleDetail($vehicle, $request->page);
                return view('site.vehicle-internal', $this->data);
            } else if ($news) {
                //url errada
                return redirect(route('details', ['title' => str_slug($news->title), 'id' => $news->id]));
            }
        }
        /**/

        return redirect(route('home'));
    }


    /*
    *
    * Detalhe do noticia
    *
    */
    public function newsDetail($news)
    {

        $news->news = News::selectRaw('posts.*')
            ->where('news.url_fapesp', '=', $news->url_fapesp)
            ->where('news.url_fapesp', '<>', '')
            ->where('news.vehicle_id', '<>', $news->vehicle_id)
            ->whereIn('news.news_status_id', News::statusActive())
            ->join('vehicles', 'news.vehicle_id', '=', 'vehicles.id')
            ->orderBy('vehicles.big', 'DESC')
            ->get();
        //dd($news->news);
        $news->source = $this->sourceSite($news);

        $this->data['news'] = $news;
    }
}
