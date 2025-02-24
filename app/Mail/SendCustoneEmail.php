<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCustoneEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mailData;
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
    public function build()
    {    
        if ($this->mailData['template'] == 'template_v1') {
            $brochure = $this->view('Email.SendCustomEmail')
                ->with('mailData', $this->mailData)
                ->subject($this->mailData['subject']);
        }

        if ($this->mailData['template'] == 'template_v2') {
            $brochure = $this->view('Email.SendCustomEmailV2')
                ->with('mailData', $this->mailData)
                ->subject($this->mailData['subject']);
        }

        if ($this->mailData['template'] == 'template_v3') {
            // dd($this);
            $brochure = $this->view('Email.SendCustomEmailV3')
                ->with('mailData', $this->mailData)
                ->subject($this->mailData['subject']);
        }
        return $brochure->from('no-reply@market-place-main.infinty-stage.com');
    }
}
