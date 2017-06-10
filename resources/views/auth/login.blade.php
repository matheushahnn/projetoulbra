<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Odonto System | Login</title>

    <link rel="stylesheet" href="{{ URL::asset('assets/css/css/bootstrap.min.css') }}" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ URL::asset('assets/css/font-awesome/css/font-awesome.css') }}" rel="stylesheet"> 
    <link href="{{ URL::asset('assets/css/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="text-center">
                <img class="logo-name" src="{{ URL::asset('assets/imgs/logo.png') }}" />
            </div>
            <h3>Odonto system</h3>
            <p>Para acessar ao sistema é preciso o seu login</p>

            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="form-group">
                        <input id="email" type="email" placeholder="E-mail" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="form-group">
                        <input id="password" type="password" placeholder="Senha" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar-me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary block full-width m-b">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>