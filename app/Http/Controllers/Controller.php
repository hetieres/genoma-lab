<?php

namespace App\Http\Controllers;

use App\Model\Post;
use App\Model\Session;
use App\Helpers\JWTHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $_public_path;
    public $_uploads_path;
    public $data = array();

    public function __construct()
    {
        $this->_public_path = "public";
        $this->_uploads_path = "files";
        $this->generateJWT();
        $this->dataLoad();
    }

    private function generateJWT()
    {
        if (is_null(Route::current()->getPrefix())) {
            $jwt = new JWTHelper;
            $token = (isset($_COOKIE['JWT-TOKEN']) ? $_COOKIE['JWT-TOKEN'] : '');
            $valid = $jwt->validateJWT($token);

            if ($valid->error) {
                $payload = ['type' => 'site', 'ip' => \Request::ip()];
                $jwt->setPayload($payload);
                $jwt->generateCookie();
            }
        }
    }

    private function dataLoad()
    {
        $prefix = $this->_treatPrefix();
        if (in_array($prefix, ['fapesp', 'admin'])) {
            $jwt   = new JWTHelper;
            $token = (isset($_COOKIE['JWT-TOKEN']) ? $_COOKIE['JWT-TOKEN'] : '');
            $user  = $jwt->getPayload($token);
            
            //paginas do admin
            if (strpos($_SERVER['REQUEST_URI'], Route::current()->getPrefix())!==false
                && in_array('auth', Route::current()->middleware()) && isset($user->id)
            ) {

                $side_news = Post::orderBy('id', 'DESC')->limit(10)->get();
                $side_edit = Post::where('user_id', '=', $user->id)
                    ->orderBy('updated_at', 'DESC')
                    ->limit(10)
                    ->get();

                $sessions_edit = Session::where('edit', '=', '1')->orderByRaw('id=1 desc, id=3 desc, id=6 desc, id=5 desc')->get();

                // dd($sessions_edit);

                View::share('side_news', $side_news);
                View::share('side_edit', $side_edit);
                View::share('sessions_edit', $sessions_edit);
            }
        }
    }

    public function rangePages($lastPage, $currentPage, $maxPages = 7)
    {
        while ($maxPages % 2 != 1) {
            $maxPages++;
        }

        $start = 1;
        $end = 0;
        $middle = (int)floor($maxPages / 2) + 1;


        if ($lastPage < 1) { //na a paginacao
            $start = 0;
            $end = -1;
        } else if ($lastPage <= $maxPages) {//1 ate ultima pagina
            $start = 1;
            $end = $lastPage;
        } else if ($currentPage <= $middle && $lastPage > $maxPages) {//1 ate MAX - atual antes do meio
            $start = 1;
            $end = $maxPages;
        } else if ($lastPage - $currentPage < ($middle - 1)) {//START ate MAX - atual apos meio
            $start = $lastPage - (($middle - 1) * 2);
            $end = $lastPage;
        } else {//ATUAL no centro PADRÃO
            $start = $currentPage - $middle + 1;
            $end = $currentPage + $middle - 1;
        }

        $pages = array();
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }
        return $pages;
    }

    private function _treatPrefix()
    {
        $ret    = '';
        $prefix = \Request::route()->getPrefix();

        if (null!==$prefix && substr($prefix, 0, 1)==='/') {
            $ret    = substr($prefix, 1);
        } else if (null!==$prefix && substr($prefix, 0, 1)!=='/') {
            $prefix = explode('/', $prefix);
            $ret    = $prefix[0];
        }

        return $ret;
    }

}
