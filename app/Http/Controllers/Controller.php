<?php

namespace App\Http\Controllers;

use App\Helpers\JWTHelper;
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

    public function numberProcessFormat($n)
    {
        $number = "";
        $j = 0;
        for ($i = strlen($n) - 1; $i > -1; $i--) {
            $number = $n[$i] . $number;
            if ($j == 0) {
                $number = "-" . $number;
            }
            if ($j == 5) {
                $number = "/" . $number;
            }
            $j++;
        }
        return $number;
    }
}
