@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/css/users.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('assets/js/admin/news-list.min.js') }}"></script>
@endsection

@section('content')
    {{-- <section class="content-header">
        <h1>
            <i class="fa fa-files-o"></i> Matérias
            <small>Lista de matérias cadastradas no sistema</small>
        </h1>
    </section> --}}

    <section class="content">
        <div class="row">
            <em-post :sessions='{!! $sessions !!}'></em-post>
        </div>
    </section>
@endsection