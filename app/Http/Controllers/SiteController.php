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
        $this->lang = $this->_treatPrefix()=='en' ? 'en' : 'pt';
        $this->setLang($this->lang);
        $this->conteudo = $conteudo;
    }

    public function setLang($lang){
        if($lang=='pt'){
            View::share('footer', Post::find(12)->text);
            View::share('menu', Post::find(19)->text);
        }else{
            View::share('footer', Post::find(100)->text);
            View::share('menu', Post::find(99)->text);
        }
        View::share('lang', $lang);
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
                                    ->where('lang', $this->lang)
                                    ->orderBy('order')
                                    ->limit(5)
                                    ->get();

        if($this->lang=='pt'){
            $sessions = Session::where('lang', $this->lang)->where('edit', '1')->orderByRaw('id=1 desc, id=6 desc, id=3 desc, id=5 desc, id=8 desc')->get();
        }else{
            $sessions = Session::where('lang', $this->lang)->where('edit', '1')->get();
        }

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
                $session->ids = $session->ids ? json_decode($session->ids): [];
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
                    $aux = Post::find($post->lang=="pt" ? 18 : 101);
                    $post->session->aside = $aux->text;
                }
                $this->setLang($post->lang);
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
            $this->setLang($session->lang);

            return view('site.list', $this->data);
        }else{
            //404
        }
    }


    public function search(Request $request)
    {
        $rs = Post::selectRaw('posts.*')->where('posts.lang', $this->lang)->whereNotIn('posts.session_id', [7, 14]);
        $request->k = trim($request->k); //chave
        $request->o = isset($request->o) ? $request->o : 1;

        //chave
        if (isset($request->k) && trim($request->k) != '') {
            $like = '%' . $request->k . '%';
            $rs->join('sessions', 'posts.session_id', 'sessions.id');
            $rs->where('sessions.search', 1);
            $rs->where(function ($query) use ($like) {
                $query->where('posts.title', 'like', $like)
                    ->orWhere('posts.text', 'like', $like)
                    ->orWhere('posts.summary', 'like', $like)
                    ->orWhere('posts.keywords', 'like', $like)
                    ->orWhere('posts.caption_image', 'like', $like);
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
