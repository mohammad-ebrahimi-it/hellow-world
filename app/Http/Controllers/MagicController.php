<?php

namespace App\Http\Controllers;

use App\Models\LoginToken;
use App\Services\Auth\MagicAuthentication;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class MagicController extends Controller
{
    private $auth;

    public function __construct(MagicAuthentication $auth)
    {
        $this->middleware('guest');
        $this->auth = $auth;
    }

    public function show()
    {
        return view('auth.magic-login');
    }

    public function sendToken(Request $request )
    {
        $this->validateForm($request);
        $this->auth->requestLink();
        return back()->with('magicLinkSent', true);

    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'email'=> 'required | email | exists:users'
        ]);

    }

    public function login(LoginToken $token)
    {

        return $this->auth->authenticate($token) === $this->auth::AUTHENTICATED
            ? redirect(route('home'))
            : redirect(route('auth.magic.login.form'))->with('invalidToken', true);

    }
}
