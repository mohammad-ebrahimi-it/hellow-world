<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Code;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\Recaptcha;
use App\Services\Auth\TwoFactorAuthentication;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//    use AuthenticatesUsers;
    use ThrottlesLogins;

    private $twoFactor;

    protected $maxAttempts = 2;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TwoFactorAuthentication $twoFactor)
    {
        $this->twoFactor = $twoFactor;

        $this->middleware('guest')->except('logout');
    }

    public function show()
    {
        dd('ali');
        return view('auth.login');
    }

    public function showCodeForm()
    {
        return view('auth.two-factor.login-code');
    }

    public function login(Request $request)
    {
        $this->validateForm($request);
//        if ($this->hasTooManyLoginAttempts($request)) {
//            return $this->sendLockoutResponse($request);
//        }

//        if (!$this->isValidCredentials($request)) {
//            $this->incrementLoginAttempts($request);
//             $this->sendLockoutResponse($request);
//        }
//        dd($request);
        $user = $this->getUser($request);

        if ($user->hasTwoFactor()) {
            $this->twoFactor->requestCodeSms($user);
            return $this->sendHasTwoFactorResponse();
        }

        Auth::login($user, $request->remember);
        return $this->sendLoginSuccessResponse();

    }

    public function confirmCode(Code $request)
    {
        $response = $this->twoFactor->login();
        return $response === $this->twoFactor::AUTHENTICATED
            ? $this->sendLoginSuccessResponse()
            : back()->with('invalidCode', true);
    }

    private function validateForm(Request $request)
    {
        $request->validate([
//            'email' => ['required', 'email', 'exists:users'],
            'phone_number' => ['required','numeric', 'digits:11', 'exists:users'],
//            'password' => ['required'],
            'g-recaptcha-response' => ['required', new Recaptcha()]
        ], [
                'g-recaptcha-response.required' => __('auth.recaptcha')
            ]
        );

    }

    protected function isValidCredentials($request)
    {
        return Auth::validate($request->only(['email', 'password']));
    }

    private function attemptLogin(Request $request)
    {
        return Auth::attempt($request->only('email', 'password'), $request->filled('remember'));
    }

    protected function sendLoginSuccessResponse()
    {
        session()->regenerate();
        return redirect()->intended();
    }

    protected function sendLoginFailedResponse()
    {
        return back()->with('failed', true);
    }

    public function logout()
    {
        session()->invalidate();
        Auth::logout();
        return redirect(route('home'));

    }

    protected function username()
    {
        return 'email';
    }

    private function getUser($request)
    {
        return User::where('phone_number', $request->phone_number)->firstOrFail();
    }

    private function sendHasTwoFactorResponse()
    {
        return redirect(route('auth.login.code.form'));
    }
}
