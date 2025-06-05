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
          <style>
            .form-group {
                position: relative;
            }

            .toggle-button {
                position: absolute;
                top: 70%;
                right: 12px; 
                transform: translateY(-50%);
                background: transparent;
                border: none;
                padding: 0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .eye-icon {
                width: 20px;
                height: 20px;
                color: #888;
            }
            button:focus{
                    outline: none;
                }
            @media (max-width: 480px) {
                .eye-icon {
                    width: 1rem; /* 16px */
                    height: 1rem;
                }
            }
        </style>
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
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                <button type="button" class="toggle-button" data-toggle="password" aria-label="Toggle Password Visibility">
                                                    <!-- Eye icon SVG -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                 <button type="button" class="toggle-button" data-toggle="password-confirm" aria-label="Toggle Password Visibility">
                                                    <!-- Eye icon SVG -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Reset Password') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script>
            const eyeIcons = {
                open: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                    </svg>`,
                closed: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" />
                        <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z" />
                        <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z" />
                    </svg>`
            };

            function addToggleListeners() {
                document.querySelectorAll('.toggle-button').forEach(button => {
                    const inputId = button.getAttribute('data-toggle');
                    const input = document.getElementById(inputId);
                    if (!input) return;

                    button.innerHTML = eyeIcons.open;

                    button.addEventListener('click', () => {
                        const isOpen = button.classList.toggle('open');
                        input.type = isOpen ? 'text' : 'password';
                        button.innerHTML = isOpen ? eyeIcons.closed : eyeIcons.open;
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', addToggleListeners);
        </script>
    </body>
</html>
