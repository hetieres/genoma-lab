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
        View::share('footer', Post::find(12)->text);
    }

    /**
     * home
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['highlights'] = Post::where('active', 1)
                                    ->where('highlight', 1)
                                    ->where('dt_publication', '<=', date('Y-m-d'))
                                    ->orderBy('order')
                                    ->limit(5)
                                    ->get();

        $sessions = Session::where('edit', '=', '1')->orderByRaw('id=1 desc, id=6 desc, id=3 desc, id=5 desc')->get();

        foreach ($sessions as $session) {
            $rs = false;
            if($session->type_list_id == 1){ //mais recentes
                $rs = Post::where('session_id', $session->id)
                    ->where('dt_publication', '<=', date('Y-m-d'))
                    ->orderBy('dt_publication', 'desc')
                    ->limit($session->limit)
                    ->get();
            }else if($session->type_list_id == 2){ //Aleatório
                $rs = Post::where('session_id', $session->id)
                    ->where('dt_publication', '<=', date('Y-m-d'))
                    ->orderByRaw("RAND()")
                    ->limit($session->limit)
                    ->get();
            }else if($session->type_list_id == 3){ //manual
                $session->ids = $session->ids ? json_decode($session->ids): false;
                $rs = Post::whereIn('id', $session->ids);
                foreach ($session->ids as $item) {
                    $rs->orderByRaw('id=' . $item . ' desc');
                }
                $rs = $rs->limit($session->limit)->get();
            }
            $session->posts = $rs;
        }
        $this->data['sessions'] = $sessions;

        return view('site.home', $this->data);
    }

    public function detalhe(Request $request)
    {

        $slug          = isset($request->slug) ? $request->slug: false;
        $id            = isset($request->id)   ? $request->id:   false;
        $count_session = Session::where('url', $slug)->count();


        // SLUG conflita com ID
        if ($slug && is_numeric($slug) === true && !$id) {
            $id = $slug;
            $slug = false;
        }

        if ($id) {
            $post = Post::find($id);
            if ($post && $slug != str_slug($post->title) && $count_session == 0) {
                return redirect($post->link(), 301);
            }else if ($post && $slug == str_slug($post->title)) {
                if($post->session->aside == ""){
                    $aux = Post::find(18);
                    
                    $post->session->aside = $aux->text;
                }
                return view('site.detail', ['post' => $post]);
            }
        }

        if ($count_session){
            if(is_numeric($id)){
                $page = $id;
                // Resolve a problem at pagination
                Paginator::currentPageResolver(
                    function () use ($page) {
                        return $page;
                    }
                );
            }
            $session = Session::where('url', $slug)->first();
            $rs = Post::where('session_id', $session->id)
                ->where('dt_publication', '<=', date('Y-m-d'))
                ->orderBy('dt_publication', 'desc')
                ->paginate(25);
            $session->posts = $rs;
            $this->data['slug']        = $slug;
            $this->data['lastPage']    = $rs->lastPage();
            $this->data['currentPage'] = $rs->currentPage();
            $this->data['rangePages']  = $this->rangePages($this->data['lastPage'], $this->data['currentPage']);
            $this->data['session']     = $session;
            return view('site.list', $this->data);
        }else{
            //404
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


}
