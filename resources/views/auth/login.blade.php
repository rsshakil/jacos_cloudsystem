<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('messages.login_title')}}</title>
    <link rel="shortcut icon" href="<?php echo(\Config::get('app.url') . '/public/backend/images/logo/favicon.ico');?>">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/app.css'}}">
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/flag-icon.css'}}">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{Config::get('app.url').'/public/css/my_login_css.css'}}">
</head>
<body>


        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                <div class="collapse navbar-collapse" id="navbarsExample09">
                        <ul class="navbar-nav border-left flex-row ">
                                <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-nowrap px-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @if(App::isLocale('ja'))
                                            <span class="flag-icon flag-icon-jp"></span> 日本語
                                            @elseif(App::isLocale('en'))
                                            <span class="flag-icon flag-icon-us"></span> English
                                            @endif
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-small" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="<?php echo(\Config::get('app.url').'/language/en');?>"><span class="flag-icon flag-icon-us"></span> English</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="<?php echo(\Config::get('app.url').'/language/ja');?>"><span class="flag-icon flag-icon-jp"></span> 日本語</a>
                                        </div>
                                    </li>
                        </ul>
                    
                </div>
            </nav>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    
    <!-- Icon -->
    <div class="fadeIn first">
      <img src="<?php echo(Config::get('app.url').'public/dashboard/logo/cropped-Jacos-main.png') ?>" id="icon" alt="User Icon" />
      
    </div><br/>
    <!-- Login Form -->
    <form method="POST" action="<?php echo(\Config::get('app.url').'/login')?>">
    @csrf
    <input id="email" type="email" placeholder="{{ __('messages.email_text') }}" class="fadeIn second{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert" style="display:block">
                    <strong>{{ __('messages.u_p_incorrect') }}</strong>
                </span>
   @endif
    
   
    <input id="password" type="password" class="fadeIn third{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('messages.password_text') }}" required>

    @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert" style="display:block">
            <strong>{{ __('messages.u_p_incorrect') }}</strong>
        </span>
    @endif
    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('messages.remember_text') }}
                </label>
            </div>
        </div>
    </div>
    
      <input type="submit" id="login" class="fadeIn fourth" value="{{ __('messages.login_text') }}">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
    @if (Route::has('password.request'))
        <a class="underlineHover" href="<?php echo(\Config::get('app.url').'/password/reset')?>">
            {{-- {{ __('messages.forgot_pass_text') }} --}}
            @lang('messages.forgot_pass_text')
        </a>
    @endif
      <!-- <a class="underlineHover" href="#">Go to the Site</a> -->
    </div>

  </div>
</div>
    <script>
        $(document).ready(function(){
            

        });
    </script>
</body>
</html>