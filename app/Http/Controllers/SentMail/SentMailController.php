<?php

namespace App\Http\Controllers\SentMail;

use App\Http\Controllers\Controller;
use App\Mail\SendCustoneEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;
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
        if ($req->ajax()) {
            $validator = $this->validateRequest($req);

            if ($validator->passes()){
                $desc = $req->desc;
                $template = $req->template;
                $subject = $req->subject;
            
                // Get selected emails from form input
                $emails = is_array($req->email) ? $req->email : (!empty($req->email) ? [$req->email] : []);
            
                // If 'All Users' is checked, fetch all user emails
                if ($req->all_users == '1') {
                    $userEmails = User::whereNotNull('email')->pluck('email')->toArray();
                    $emails = array_merge($emails, $userEmails);
                }
            
                // If 'All Subscribers' is checked, fetch all newsletter emails
                if ($req->all_newsletter == '1') {
                    $newsletterEmails = Newsletter::whereNotNull('email')->pluck('email')->toArray();
                    $emails = array_merge($emails, $newsletterEmails);
                }
            
                // Remove invalid or duplicate emails
                $emails = array_values(array_unique(array_filter($emails, function ($email) {
                    return filter_var($email, FILTER_VALIDATE_EMAIL); // Remove invalid emails
                })));
                
                if (empty($emails)) {
                    return response()->json(['message' => 'No valid recipients found'], 400);
                }
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
                return response()->json(['success' => "Mails sent successfully"]);
             }else{
                return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            }
        }
    } 
    private function validateRequest(Request $request)
    {
        $rules = [
            'emailOption' => 'required|in:user,manual',
            'email' => 'required_if:emailOption,user|array',
            'email.*' => 'email',
            'subject' => 'required|string|max:255',
            'desc' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Strip HTML tags and check if empty or only whitespace
                    if (trim(strip_tags($value)) === '') {
                        $fail('The description is required.');
                    }
                }
            ],
            'template' => 'required|in:template_v1,template_v2,template_v3',
        ];

        $messages = [
            'email.required_if' => 'Please select at least one email.',
            'desc.required' => 'The description is required.',
            'subject.required' => 'The subject is required.',
            'template.required' => 'Please select an email template.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Custom rule: at least one checkbox checked (either all users or all newsletter)
        return $validator;
    }

  
}
