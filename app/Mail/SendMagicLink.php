<?php

namespace App\Mail;

use App\Models\LoginToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMagicLink extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $options;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(LoginToken $token, $options)
    {
        $this->token = $token;
        $this->options = $options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('eamil.magic-link')->with([
            'link' => $this->buildLink()
        ]);
    }

    private function buildLink()
    {
        return route('auth.magic.login', [
           'token' => $this->token->token,

        ] + $this->options);
    }
}
