<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $app_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email , $app_name)
    {
        $this->email = $email;
        $this->app_name = $app_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Subscribing!')
                    ->view('Email.Newsletter')
                    ->with([
                        'email' => $this->email,
                        'app_name' => $this->app_name,
                    ]);
    }

}
