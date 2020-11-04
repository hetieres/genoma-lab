{{-- @extends('layouts.site') --}}

@if(file_exists(Auth::user()->image))
    @php($photo = asset(Auth::user()->image))
@else
    @php($photo = asset('assets/img/user.jpg'))
@endif

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.baseUrl = "{{ asset('/') }}";</script>

    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon" />

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/iCheck/square/red.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet">


    @yield('styles')

    <link href="{{ asset('assets/css/admin.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition sidebar-mini {{-- fixed --}} {{-- sidebar-mini-expand-feature-sidebar-collapse --}}">
    <div class="wrapper">
        <header class="main-header">
            <a href="{{ route('dashboard') }}" class="logo">
                <span class="logo-mini">
                    <img src="{{ asset('assets/img/logo-mini.png') }}" alt="logo">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('assets/img/logo-full.png') }}" alt="logo">
                </span>
            </a>

            <nav class="navbar navbar-static-top">
                <a href="javascript:;" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <span>{{ Auth::user()->name }}</span>&nbsp;&nbsp;<i class="fa fa-angle-left"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ $photo }}" class="img-circle" alt="User Image">

                                    <p>
                                        <span>{{ Auth::user()->name }}</span>
                                        <small>Usuário desde {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y') }}</small>
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <div class="col-xs-6">
                                        <a href="javascript:;" id="userProfile" class="btn btn-success btn-block noBorderRadius">
                                            <i class="fa fa-user"></i>&nbsp;&nbsp;Perfil
                                        </a>
                                    </div>

                                    <div class="col-xs-6">
                                        <a href="{{ route('logout') }}"
                                            class="btn btn-danger btn-block noBorderRadius"
                                            onclick="event.preventDefault(); $('#logout-form').submit();">
                                            <i class="fa fa-power-off"></i>&nbsp;&nbsp;Sair
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        {{-- <li>
                            <a href="javascript:;" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li> --}}
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            @include('layouts.includes.app-sidebar')
        </aside>

        <div id="main" class="content-wrapper">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')

            <nm-user-profile user="{{ Auth::user() }}"></nm-user-profile>
        </div>

        @include('layouts.includes.app-footer')

        {{-- @include('layouts.includes.app-sidebar-config') --}}

        <div class="control-sidebar-bg"></div>
    </div>

    <div id="modalPage" aria-labelledby="Label" role="dialog" tabindex="-1" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	                <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body"></div>

                <div class="modal-footer"></div>
	        </div>
	    </div>
	</div>


    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/input-mask/inputmask.js') }}"></script>
    <script src="{{ asset('assets/vendor/input-mask/inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/vendor/input-mask/inputmask.numeric.extensions.js') }}"></script>
    <script src="{{ asset('assets/vendor/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/admin.min.js') }}"></script>
    <script src="{{ asset('assets/js/general.min.js') }}"></script>
    @yield('scripts')
</body>
</html>