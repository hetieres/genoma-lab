@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-fw fa-link"></i> URL's
            <small>relatórios</small>
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
            <em-url :types='{!! $types !!}'></em-url>
        </div>
    </section>
@endsection