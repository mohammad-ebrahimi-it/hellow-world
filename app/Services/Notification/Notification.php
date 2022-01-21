<?php


namespace App\Services\Notification;
use App\Services\Notification\Providers\Contracts\Provider;
use App\User;
use Illuminate\Contracts\Mail\Mailable;


/**
  * @method sendSms(User $user, String $text)
  * @method sendEmail(User $user, Mailable $mailable)
  */

class Notification
{
    public function __call($method, $arguments)
    {
        $providerPath = __NAMESPACE__ . '\Providers\\' . substr($method, 4) . 'Provider';

        if (!class_exists($providerPath)){
            throw new \Exception("class dose not exist");
        }
        $providerInstance = new $providerPath(...$arguments);

        if (!is_subclass_of($providerInstance, Provider::class)){
            throw new \Exception("class must implements Provider");
        }

        return $providerInstance->send();


    }

}
