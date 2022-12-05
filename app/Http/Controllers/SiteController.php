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
use App\Model\SystemKey;
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
    private $load;

    /**
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request, Post $conteudo)
    {
        $this->lang = $this->_treatPrefix()=='en' ? 'en' : 'pt';
        $this->setLang($this->lang);
        $this->conteudo = $conteudo;
        $this->load = false;
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

        $this->data['genes']          = Gene::where('active', 1)->orderBy('description')->get();
        $this->data['especialidades'] = MedicalSpecialty::where('active', 1)->where('description' , '<>', 'Todas')->orderBy('description')->get();
        $this->data['casais']         = MedicalSpecialty::where('active', 1)->where('description' , 'like', 'triagem para casais')->first();
        $this->data['duvidas']        = Post::find(195);
        $this->data['sobre']          = Post::find(196);
        $this->data['aconselhamento'] = Post::find(198);
        $this->data['tests']          = GeneticTest::where('active', 1)->orderBy('description')->get();



        return view('site.home', $this->data);
    }

    public function pesquisa(Request $request)
    {
        $rs = GeneticTest::selectRaw('length(genes) - length(replace(genes, \',\' , \'\')) + 1 totalg, genetic_tests.*')
                        ->where('active', 1);
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
                    if(strtolower($specialty->description) != 'triagem para casais'){
                        $rs->orWhere('medical_specialty', 'like', '%todas%');
                    }
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
        $rs = $rs->orderByRaw('medical_specialty = \'Todas\' desc')
                ->orderByRaw('code = \'Exoma-NGS\' desc')
                ->orderByRaw('code = \'TrioExoma-NGS\' desc')
                ->orderByRaw('code = \'Geneunico-NGS\' desc')
                ->orderByRaw('code = \'GeneMUT-NGS\' desc')
                ->orderByRaw('code = \'GeneMUT-Sanger\' desc')
                ->orderByRaw('code = \'Custom-NGS\' desc')
                ->orderByRaw('code = \'Custom10-NGS\' desc')
                ->orderBy('priority', 'desc')
                ->orderByRaw('code = \'TPpainelCasal-NGS\' desc')
                ->orderByRaw('code = \'TPpainel-NGS\' desc')
                ->orderByRaw('code = \'TPpainelCasal-NGS-MLPA\' desc')
                ->orderByRaw('code = \'TPpainel-NGS-MLPA\' desc')
                ->orderBy('totalg', 'desc')
                ->orderBy('test')
                ->paginate(20);


        $this->data['rs']             = $rs;
        $this->data['lastPage']       = $rs->lastPage();
        $this->data['currentPage']    = $rs->currentPage();
        $this->data['rangePages']     = $this->rangePages($this->data['lastPage'], $this->data['currentPage']);
        $this->data['genes']          = Gene::where('active', 1)->orderBy('description')->get();
        $this->data['especialidades'] = MedicalSpecialty::where('active', 1)->where('description' , '<>', 'Todas')->orderBy('description')->get();
        $this->data['tests']          = GeneticTest::where('active', 1)->orderBy('priority', 'desc')->orderBy('test')->get();
        $this->data['k']              = isset($request->k) ? $request->k : '';
        $this->data['url']            = isset($request->k) && $request->k != '' ? '?k=' . $request->k . '&pg=' : '?pg=';


        return view('site.pesquisa', $this->data);
    }

    public function especialidades(Request $request)
    {
        $this->data['especialidades'] = MedicalSpecialty::where('active', 1)->where('description', '<>', 'Todas')->where('description', '<>', 'triagem para casais')->orderBy('description')->get();

        return view('site.especialidades', $this->data);
    }

    public function teste(Request $request)
    {
        $this->data['test'] = GeneticTest::where('active', 1)->where('id', $request->id)->first();

        return view('site.genetic-test', $this->data);
    }

    public function solicitacao(Request $request)
    {

        if($request->email){
            $test     = GeneticTest::where('id', $request->id)->first();

            $conteudo = "<h3>Contato do Laboratório Genoma</h3>";
            $conteudo .= "<p>Nome: " . $request->nome . "</p>";
            $conteudo .= "<p>e-mail: " . $request->email . "</p>";
            $conteudo .= "<p>Telefone: " . $request->telefone . "</p>";
            $conteudo .= "<p>Mensagem do solicitante: <br>" . $request->mensagem . "</p>";
            $conteudo .= "<br><b>Interesse pelo exame:</b>";
            $conteudo .= "<p>Código: " . $test->code . "</p>";
            $conteudo .= "<p>Genes: " . $test->genes . "</p>";
            $conteudo .= "<p>Doença(s): " . $test->test . "</p>";
            $conteudo = "<html>". $conteudo ."</html>";

            $mail = new PHPMailer();
            $mail->IsSMTP();		    // Ativar SMTP
            $mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
            $mail->SMTPAuth = true;		// Autenticação ativada
            $mail->SMTPSecure = "tls"; // conexão segura com TLS
            $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
            $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true); // Enviar como HTML
            $mail->Username = env('guser');
            $mail->Password = env('gsenha');
            $mail->SetFrom($request->email, 'Genoma');
            $mail->Subject = 'Contato Laboratório Genoma: ' . $request->nome;
            $mail->Body =  $conteudo;
            $mail->addReplyTo($request->email, $request->nome);
            $mail->AddAddress('heitor.shimizu@gmail.com');
            // $mail->AddAddress('hetieres@gmail.com');
            $mail->AddAddress('especialista_cegh@ib.usp.br');

            if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == UPLOAD_ERR_OK) {
                $mail->AddAttachment($_FILES['anexo']['tmp_name'],
                                    $_FILES['anexo']['name']);
            }

            if(!$mail->Send()) {
                $this->data['text'] = '<p>Erro ao enviar e-mail:</p><p>'. $mail->ErrorInfo .'</p>';
            } else {
                $this->data['text'] = '<p>Obrigado.</p><p>Recebemos sua solicitação e retornaremos o contato em breve.</p>';
            }

            $this->data['title'] = 'Solicitar exame';

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
        if($request->email){

            $conteudo = "<h3>Contato do Laboratório Genoma</h3>";
            $conteudo .= "<p>Nome: " . $request->nome . "</p>";
            $conteudo .= "<p>e-mail: <a href=\"mailto:" . $request->email . "\">" . $request->email . "</a></p>";
            $conteudo .= "<p>Telefone: " . $request->telefone . "</p>";
            $conteudo .= "<p>Mensagem do solicitante: <br>" . $request->mensagem . "</p>";
            $conteudo = "<html>". $conteudo ."</html>";

            $mail = new PHPMailer();
            $mail->IsSMTP();		    // Ativar SMTP
            $mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
            $mail->SMTPAuth = true;		// Autenticação ativada
            $mail->SMTPSecure = "tls"; // conexão segura com TLS
            $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
            $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
            $mail->CharSet = 'UTF-8';
            $mail->IsHTML(true); // Enviar como HTML
            $mail->Username = env('guser');
            $mail->Password = env('gsenha');
            $mail->SetFrom($request->email, 'Genoma');
            $mail->Subject = 'Contato Laboratório Genoma: ' . $request->nome;
            $mail->Body =  $conteudo;
            $mail->addReplyTo($request->email, $request->nome);
            $mail->AddAddress('heitor.shimizu@gmail.com');
            $mail->AddAddress('hetieres@gmail.com');
            $mail->AddAddress('especialista_cegh@ib.usp.br');
            if(!$mail->Send()) {
                $this->data['text'] = '<p>Erro ao enviar e-mail:</p><p>'. $mail->ErrorInfo .'</p>';
            } else {
                $this->data['text'] = '<p>Obrigado.</p><p>Recebemos sua solicitação e retornaremos o contato em breve.</p>';
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



}