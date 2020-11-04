@extends('layouts.auth')

@section('content')
    @if($errors->any())
        <div class="callout callout-danger infosLogin">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {!! $errors->first() !!}
        </div>
    @endif

    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo FAPESP Na Mídia" class="img-responsive">
        </div>

        <div class="login-box-body">
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback">
                    <input id="email" type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}" required>
                    <span class="fa fa-envelope-o form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input id="password" type="password" placeholder="Senha" class="form-control" name="password" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <div class="form-group">
                    <button id="btnLogin" type="submit" class="btn btn-fp btn-block btn-flat">Entrar</button>
                </div>
            </form>

            <div class="buttons row">
                <div class="col-xs-6">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Manter conectado
                        </label>
                    </div>
                </div>

                <div class="col-xs-6">
                    <a class="btnRequest" href="{{ route('password.request') }}">
                        Esqueceu sua senha?
                    </a>
                </div>
            </div>
        </div>

        @include('auth.includes.copyright')
    </div>
@endsection
