@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
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
        @if ($site && $site['value']['site_favicon'])
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
            <div class="auth-content" style="min-width: 400px !important">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                {{-- <div class="auth-logo text-center mb-4">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="">
                                </div> --}}
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <h1 class="mb-3 text-18">Sign In</h1>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input id="email"
                                            class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password"
                                            class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password" type="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <div class="">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-rounded btn-primary btn-block mt-2">Sign In</button>

                                </form>
                                @if (Route::has('password.request'))

                                <div class="mt-3 text-center">

                                    <a href="{{ route('password.request') }}" class="text-muted"><u>Forgot
                                            Password?</u></a>
                                </div>
                                @endif
                                {{-- <div class="text-center">
                                    <a href="{{ route('register') }}" class="text-muted"><u>Sign Up</u></a>
                                </div >--}}
                            </div>
                        </div>
                        {{-- <div class="col-md-6 text-center "
                            style="background-size: cover;background-image: url({{asset('assets/images/photo-long-3.jpg')}}">
                            <div class="pr-3 auth-right">
                                @if (Route::has('register'))


                                <a href="{{ route('register') }}"
                                    class="btn btn-rounded btn-outline-primary btn-outline-email btn-block btn-icon-text">
                                    <i class="i-Mail-with-At-Sign"></i> Sign up with Email
                                </a>
                                @endif
                                <a
                                    class="btn btn-rounded btn-outline-primary btn-outline-google btn-block btn-icon-text">
                                    <i class="i-Google-Plus"></i> Sign up with Google
                                </a>
                                <a
                                    class="btn btn-rounded btn-outline-primary btn-block btn-icon-text btn-outline-facebook">
                                    <i class="i-Facebook-2"></i> Sign up with Facebook
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>

        <script src="{{asset('assets/js/script.js')}}"></script>
    </body>

</html>
