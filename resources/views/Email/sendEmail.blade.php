@component('mail::message')
    # {{ $mailData['title'] }}
    Use Below Credentials For The Login Into ERP
    Email: {{ $mailData['email'] }}
    Password: {{ $mailData['password'] }}
@component('mail::button', ['url' => $mailData['url']])
    Click here to login
@endcomponent
Thanks,<br>
    {{ config('app.name') }}
@endcomponent