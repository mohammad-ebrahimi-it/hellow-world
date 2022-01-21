<?php

namespace App\Services\Auth;

use App\Models\TwoFactor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthentication
{
    const CODE_SENT = 'code.sent';
    const INVALID_CODE = 'code.invalid';
    const ACTIVATED = 'code.activated';
    const AUTHENTICATED = 'code.authenticated';

    protected $request;
    protected $code;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function requestCodeSms(User $user)
    {
        $code = TwoFactor::generateCodeFor($user);

        $this->setSession($code);

        $code->sendSms();
        return static::CODE_SENT;
    }

    public function requestCodeEmail(User $user)
    {
        $code = TwoFactor::generateCodeFor($user);

        $this->setSession($code);

        $code->sendEmail();
        return static::CODE_SENT;
    }

    protected function setSession(TwoFactor $twoFactor)
    {
        session([
            'code_id' => $twoFactor->id,
            'user_id' => $twoFactor->user_id,
            'remember' => $this->request->remember
        ]);

    }

    public function activate()
    {
        if (!$this->isValidCode())
            return static::INVALID_CODE;

        $this->getToken()->delete();


        $this->getUser()->activateTwoFactor();

        $this->forgetSession();

        return static::ACTIVATED;

    }

    protected function isValidCode()
    {
        return !$this->getToken()->isExpired() && $this->getToken()->isEqualWith($this->request->code);
    }

    protected function getToken()
    {

        return $this->code ?? $this->code = TwoFactor::findOrFail(session('code_id'));
    }

    protected function getUser()
    {
        return User::findOrFail(session('user_id'));
    }

    protected function forgetSession()
    {
        session('code_id', 'user_id', 'remember');
    }

    public function deactivate(User $user)
    {
        return $user->deactivateTwoFactor();

    }

    public function login()
    {
        if (!$this->isValidCode()){
            $this->getToken()->delete();
        }

        Auth::login($this->getUser(), session('remember'));

        $this->forgetSession();

        return static::AUTHENTICATED;

    }

    public function resent()
    {
        return $this->requestCodeSms($this->getUser());
    }

}
