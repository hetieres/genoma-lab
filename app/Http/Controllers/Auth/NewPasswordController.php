<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\PasswordBroker;

class NewPasswordController extends Controller
{
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/fapesp';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create(Request $request, $token = null)
    {
        return view('auth.passwords.new')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function test()
    {
        if ($user = User::where('email', 'admin@fapesp.br')->first()) {
            $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

            echo '<pre>';
            print_r($token);
            echo '</pre>';
            die();
        }
    }
}
