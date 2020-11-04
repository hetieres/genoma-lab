@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/css/users.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" async="async" />
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" async="async"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" async="async"></script>
    <script src="{{ asset('assets/js/admin/news-list.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-files-o"></i> Relatórios
            <small>Relatórios gerenciais da equipe</small>
        </h1>
        <!--
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><i class="fa fa-users"></i> Usuários</li>
        </ol>
        -->
    </section>

    <section class="content">
        <div class="row">
            <em-team></em-team>
        </div>
    </section>
@endsection