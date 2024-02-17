@component('mail::message')
    # {{ $mailData['title'] }}
    You are receiving this email because we received a password reset request for your account.    
@component('mail::button', ['url' => $mailData['url']])
    Click here to login
@endcomponent
This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

Regards,
Thanks,<br>
    {{ config('app.name') }}
@endcomponent