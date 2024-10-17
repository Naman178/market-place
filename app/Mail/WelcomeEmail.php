<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $generatedPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     
    public function __construct($user, $generatedPassword)
    {
        $this->user = $user;
        $this->generatedPassword = $generatedPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
   public function build()
    {
        return $this->view('Email.welcome') // Create this Blade view
                    ->with([
                        'name' => $this->user->name,
                        'generatedPassword' => $this->generatedPassword,
                    ]);
    }
}
