@extends('layouts.auth')

@section('content')
    @if (session('status'))
        <div class="callout callout-success infosLogin">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    @if ($errors->has('email'))
        <div class="callout callout-danger infosLogin">
            <h4>Ocorreu um erro</h4>

            <p>{{ $errors->first('email') }}</p>
        </div>
    @endif

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('dashboard') }}" title="voltar">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo FAPESP Na Mídia" class="img-responsive">
            </a>
        </div>

        <div class="login-box-body">
            <h2>Defina sua nova senha</h2>

            <form method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}" required>
                    <span class="fa fa-envelope-o form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" placeholder="Senha" class="form-control" name="password" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input id="password-confirm" type="password" placeholder="Confirmar Senha" class="form-control" name="password_confirmation" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <button id="btnLogin" type="submit" class="btn btn-wm btn-block btn-flat">Redefinir a Senha</button>
                </div>
            </form>
        </div>

        @include('auth.includes.copyright')
    </div>
@endsection
