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
            <h2>Resetar a Senha</h2>

            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group has-feedback">
                    <input id="email" type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}" required>
                    <span class="fa fa-envelope-o form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <button id="btnLogin" type="submit" class="btn btn-fp btn-block btn-flat">Enviar Link para Resetar Senha</button>
                </div>
            </form>
        </div>

        @include('auth.includes.copyright')
    </div>
@endsection
