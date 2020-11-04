@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/css/users.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/users.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Usuários
            <small>Lista dos usuários cadastrados no sistema</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div id="lineBox" class="box-body">
                        <div id="search">
                            <input type="text" class="form-control" placeholder="Buscar..." />
                            <i class="icon fa fa-search"></i>
                        </div>

                        <div id="buttons">
                            <button class="btnNew"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <nm-users id="{{ Auth::user()->id }}"></nm-users>
        </div>
    </section>
@endsection