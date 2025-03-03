<?php

namespace App\Http\Controllers\SentMail;

use App\Http\Controllers\Controller;
use App\Mail\SendCustoneEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Mail;

class SentMailController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::get();
        $users = User::get();
        return view('pages.SentMail.sentMail',compact('newsletters' , 'users'));
    }
    public function preview(Request $req)
    {
        $desc = $req->desc;
        $template = $req->template;
        $email = $req->email[0];
        $subject = $req->subject;
        $mailData = [
            'email' => $email,
            'desc' => $desc,
            'template' => $template,
            'subject' => $subject,
            'title' => 'Dear ' . $email,
        ];
        return new \App\Mail\SendCustoneEmail($mailData);
    }
    public function store(Request $req)
    {
        $desc = $req->desc;
        $template = $req->template;
        $emails = is_array($req->email) ? $req->email : [$req->email];
        // dd($emails);
        $subject = $req->subject;

        foreach ($emails as $email) {
            $mailData = [
                'email' => $email,
                'desc' => $desc,
                'template' => $template,
                'subject' => $subject,
                'title' => 'Dear ' . " " .$email,
            ];
            // Mail
            Mail::to($email)->send(new SendCustoneEmail($mailData));
        }
        return response()->json(['message' => "mails sent successfully"]);
    }
}
