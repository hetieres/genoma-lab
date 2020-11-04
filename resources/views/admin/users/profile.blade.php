@extends('layouts.app')

@if(file_exists(Auth::user()->image))
    @php($photo = asset(Auth::user()->image))
@else
    @php($photo = asset('assets/img/system/user.jpg'))
@endif

@section('styles')
    <link href="{{ asset('assets/css/system/users.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/system/users.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="ion ion-ios-home"></i> Usuário
            <small>Visualizando o perfil do usuário <i>"{{ Auth::user()->name }}"</i></small>
        </h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            @if(Auth::user()->type==='admin') <li><a href="{{ route('sys-users') }}"><i class="fa fa-users"></i> Usuários</a></li>@endif
            <li class="active"><i class="fa fa-user"></i> Perfil</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header bg-yellow noBorderRadius">
                        <div class="widget-user-image">
                        <img class="img-circle" src="{{ $photo }}" alt="User Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                        <h5 class="widget-user-desc">Usuário desde {{ \Carbon\Carbon::parse(Auth::user()->created_at)->formatLocalized('%d de %B de %Y') }}</h5>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                        <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                        <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                        <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                        <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection