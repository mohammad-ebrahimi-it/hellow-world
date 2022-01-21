<?php

namespace App\Listeners;

use App\Events\UserRegister;
use App\Events\UserRegistered;

class SendVerificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRegistered $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $event->user->sendEmailVerificationNotification();
    }
}
