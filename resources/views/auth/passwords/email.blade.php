@php
    use App\Models\Settings;
    $site = $site = Settings::where('key','site_setting')->first();
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{$site["value"]["site_name"] ?? "Infinity"}}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
        @if ($site &&$site['value']['site_favicon'])
            <link rel="icon"  href="{{asset('storage/Logo_Settings/'.$site['value']['site_favicon'])}}">
        @endif
    </head>
    <body>
    <?php
        $setting = \App\Models\Settings::where('key','login_register_settings')->first();
        $bg_url = '';
        if(!empty($setting['value']['login_register_bg'])){
            $bg_url = asset('storage/Login_Register_Settings/'.$setting['value']['login_register_bg']);
        }
        else{
            $bg_url = asset('assets/images/photo-wide-4.jpg');
        }
    ?>
        <div class="auth-layout-wrap" style="background-image: url({{$bg_url}})">
            <div class="auth-content" style="min-width: 450px !important">
                <div class="card o-hidden">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">{{ __('Reset Password') }}</div>
                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input type="email" name="email" class="form-control" required autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('login') }}" class="text-muted"><u>Return to Login</u></a>
                                    </div >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
    </body>
</html>
