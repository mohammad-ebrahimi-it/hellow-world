<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function show(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->query('token'),
            'email' => $request->query('email')
        ]);
    }

    public function reset(Request $request)
    {
        $this->validateForm($request);

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmed', 'token'),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response === Password::PASSWORD_RESET
            ? redirect(route('auth.login'))->with('passwordChanged', true)
            : back()->with('cantChangePassword', true);
    }

    protected function validateForm(Request $request)
    {
        $request->validate([
            'password' => 'required | string | min:8 | confirmed',
            'email' => 'required | email | exists:users',
            'token' => 'required | string'
        ]);
    }

    private function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
