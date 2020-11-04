@extends('layouts.app')

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin/url-edit.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-fw fa-link"></i> URL's
            <small>cadastro</small>
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Inserir URL's</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Tema</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control required" id="topic" name="topic">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">URL's</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <textarea class="form-control required" id="url" rows="20"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url_type_id" class="col-sm-2 control-label">Pendência</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2 required" name="url_type_id" id="url_type_id">
                                            <option value=""> - </option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button class="btn btn-info" id="save">Gravar</button>
                        </div>
                    </div>
                </div>
                <div class="text-red text-center load d-none">
                    <img class="loading" src="{{ asset('assets/img/loading.svg') }}"  style="width: 100%; height: 200px;"/>
                </div>
            </div>
        </div>
    </section>
@endsection