@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('assets\vendor\highcharts\highcharts.js') }}"></script>
    <script src="{{ asset('assets\vendor\highcharts\exporting.js') }}"></script>
    <script src="{{ asset('assets\vendor\highcharts\export-data.js') }}"></script>
    <script src="{{ asset('assets\js\admin\dashboard.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-ticket"></i> Dashboard
            <small>Fapesp na Mídia</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div id="container"></div>
            </div>
            <div class="col-xs-6">
                <div id="container1"></div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div id="container0"></div>
            </div>
            <div class="col-xs-6">
                <div id="container2"></div>
            </div>
        </div>
    </section>
@endsection
