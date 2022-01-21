<?php

namespace App\Services\Auth;

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Self_;

class MagicAuthentication
{
    const INVALID_TOKEN = 'token.invalid';
    const AUTHENTICATED = 'authenticated';

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function requestLink()
    {
        $user = $this->getUser();

        $user->createTokenUser()->sendLink([
            'remember' => $this->request->has('remember')
        ]);

    }

    private function getUser()
    {
        return User::where('email', $this->request->email)->firstOrFail();
    }

    public function authenticate(LoginToken $token)
    {
        $token->delete();

        if ($token->isExpired()) {
            return self::INVALID_TOKEN;
        }

        Auth::login($token->user, $this->request->query('remember'));

        return self::AUTHENTICATED;

    }

}
