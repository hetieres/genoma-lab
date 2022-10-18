<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use Carbon\Carbon;
use App\Model\Gene;
use App\Model\News;
use App\Model\Post;
use App\Model\Video;
use App\Model\Country;
use App\Model\Session;
use App\Model\Category;
use App\Model\MediaType;
use App\Model\GeneticTest;
use App\Helpers\BaseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Str;
use App\Model\MedicalSpecialty;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
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

        $this->data['genes']          = Gene::orderBy('description')->get();
        $this->data['especialidades'] = MedicalSpecialty::where('description' , '<>', 'Todas')->orderBy('description')->get();
        $this->data['casais']         = MedicalSpecialty::where('description' , 'like', 'triagem para casais')->first();
        $this->data['duvidas']        = Post::find(195);
        $this->data['sobre']          = Post::find(196);
        $this->data['aconselhamento'] = Post::find(198);
        $this->data['tests']          = GeneticTest::orderBy('description')->get();

        return view('site.home', $this->data);
    }

    public function pesquisa(Request $request)
    {
        $rs = GeneticTest::where('active', 1);
        $request->k = trim($request->k); //chave

        //chave
        if (isset($request->k) && trim($request->k) != '') {
            $type = substr($request->k, 0, 2);
            $id = substr($request->k, 2);

            //especialidade medica
            if($type == 'e_'){
                $specialty = MedicalSpecialty::find($id);
                if($specialty && strtolower($specialty->description) != 'todas'){
                    $rs->where('medical_specialty', 'like', '%' . $specialty->description . '%');
                    $rs->orWhere('medical_specialty', 'like', '%todas%');
                }
            }

            //gene
             if($type == 'g_'){
                $gene = Gene::find($id);
                if($gene){
                    $rs->where('genes', 'like', '%' . $gene->description . '%');
                }
            }
        }

        //set pagina atual
        Paginator::currentPageResolver(function () use ($request) {
            $request->pg = (int) $request->pg;
            return $request->pg;
        });

        $this->data['count'] = $rs->count();
        $rs = $rs->orderBy('priority', 'desc')->orderBy('test')->paginate(20);


        $this->data['rs']             = $rs;
        $this->data['lastPage']       = $rs->lastPage();
        $this->data['currentPage']    = $rs->currentPage();
        $this->data['rangePages']     = $this->rangePages($this->data['lastPage'], $this->data['currentPage']);
        $this->data['genes']          = Gene::orderBy('description')->get();
        $this->data['especialidades'] = MedicalSpecialty::where('description' , '<>', 'Todas')->orderBy('description')->get();
        $this->data['tests']          = GeneticTest::orderBy('priority', 'desc')->orderBy('test')->get();
        $this->data['k']              = isset($request->k) ? $request->k : '';
        $this->data['url']            = isset($request->k) && $request->k != '' ? '?k=' . $request->k . '&pg=' : '?pg=';


        return view('site.pesquisa', $this->data);
    }

    public function especialidades(Request $request)
    {
        $this->data['especialidades'] = MedicalSpecialty::where('description', '<>', 'Todas')->where('description', '<>', 'triagem para casais')->orderBy('description')->get();

        return view('site.especialidades', $this->data);
    }

    public function teste(Request $request)
    {
        $this->data['test'] = GeneticTest::where('id', $request->id)->first();
        return view('site.genetic-test', $this->data);
    }

    public function solicitacao(Request $request)
    {
        if($request->email){
            $test     = GeneticTest::where('id', $request->id)->first();
            $to       = 'hetieres@hotmail.com';
            $from     = $request->nome . ' <' . $request->email . '>';
            $subject  = 'Contato via SITE - ' . $request->mensagem;
            $conteudo = $request->mensage;

            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
            $headers .= "From: $from\r\n";
            $headers .= "Return-path: $from\r\n";

            $conteudo = "<h3>Contato do Laboratório Genoma</h3>";
            $conteudo .= "<p>Nome: " . $request->nome . "</p>";
            $conteudo .= "<p>e-mail: " . $request->email . "</p>";
            $conteudo .= "<p>Telefone: " . $request->telefone . "</p>";
            $conteudo .= "<p>Mensagem do solicitante: <br>" . $request->mensagem . "</p>";
            $conteudo = "<br><b>Interesse pelo teste:</b>";
            $conteudo .= "<p>Código: " . $test->code . "</p>";
            $conteudo .= "<p>Genes: " . $test->genes . "</p>";
            $conteudo .= "<p>Doença(s): " . $test->test . "</p>";

            @$mail= mail($to, $subject, $conteudo, $headers);

            $this->data['title'] = 'Solicitar exame';
            $this->data['text'] = '<p>Exame solicitado com sucesso.</p>';

            return view('site.mensagem', $this->data);
        }
        $this->data['test'] = GeneticTest::where('id', $request->id)->first();
        return view('site.solicitacao', $this->data);
    }

    public function info(){
        phpinfo();
    }

    public function contato(Request $request)
    {
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', 1);
        if($request->email){

            $conteudo = "<h3>Contato do Laboratório Genoma</h3>";
            $conteudo .= "<p>Nome: " . $request->nome . "</p>";
            $conteudo .= "<p>e-mail: " . $request->email . "</p>";
            $conteudo .= "<p>Telefone: " . $request->telefone . "</p>";
            $conteudo .= "<p>Mensagem do solicitante: <br>" . $request->mensagem . "</p>";
            $conteudo = "<html>". $conteudo ."</html>";

            $mail = new PHPMailer();
            $mail->IsSMTP();		    // Ativar SMTP
            $mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
            $mail->SMTPAuth = true;		// Autenticação ativada
            // $mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
            $mail->SMTPSecure = "tls"; // conexão segura com TLS
            $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
            $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true); // Enviar como HTML
            // dd(env('guser'));
            $mail->Username = env('guser');
            $mail->Password = env('gsenha');
            $mail->SetFrom($request->email, 'Sistema');
            // $mail->From = "hetieres@gmail.com"; // From
            // $mail->FromName = "Sistema"; // Nome de quem envia o email
            $mail->Subject = 'Contato via SITE - ' . $request->nome;
            $mail->Body =  $conteudo;
            $mail->AddAddress('hetieres@hotmail.com');
            if(!$mail->Send()) {
                // dd($mail);
                $this->data['text'] = '<p>Erro ao enviar e-mail:</p><p>'. $mail->ErrorInfo .'</p>';
            } else {
                $this->data['text'] = '<p>E-mail enviado com sucesso.</p>';
            }

            $this->data['title'] = 'Contato';

            return view('site.mensagem', $this->data);
        }

        return view('site.contato', $this->data);
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
