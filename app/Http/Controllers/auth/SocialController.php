<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function providerCallBacK($driver)
    {
        $user = Socialite::driver($driver)->user();

        Auth::login($this->findOrCreateUser($user, $driver));

        return redirect()->intended();
    }

    private function findOrCreateUser($user, $driver)
    {
        $providerUser = User::where([
            'email' => $user->getEmail()
        ])->first();

        if ($providerUser)
            return $providerUser;

        dd(";o;");
//        return User::create([
//            'email'=> $user->getEmail(),
//            'name' => $user->getName(),
//            'provider' => $driver,
//            'provider_id' => $user->getId(),
//            'avatar' => $user->getAvatar(),
//            'email_verified_at' => Carbon::now()
//
//        ]);

//        throw new \Exception('error.login');

//            return response()->view('errors.invalid-order', [], 500);
//        return back()->with('errorForLoginToGoogle', true);
        return redirect(route('auth.login'))->with('error', "this is error");


    }

}
