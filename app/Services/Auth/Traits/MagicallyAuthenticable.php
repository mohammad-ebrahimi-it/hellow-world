<?php

namespace App\Services\Auth\Traits;

use App\Jobs\SendEmail;
use App\Mail\SendMagicLink;
use App\Models\LoginToken;
use Illuminate\Support\Str;

trait MagicallyAuthenticable
{
    public function magicToken()
    {
        return $this->hasOne(LoginToken::class);
    }

    public function createTokenUser()
    {
        $this->magicToken()->delete();

        return $this->magicToken()->create([
            'token' => Str::random(50)
        ]);
    }


}
