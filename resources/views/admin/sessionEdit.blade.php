@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/admin/session-edit.min.js?v=2') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-object-group"></i> {{ $session->description }}
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
                    {{-- <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-object-group"></i>{{ $session->description }}</h3>
                    </div> --}}
                    <div class="box-body">
                        <form class="form-horizontal" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Seção</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control required" id="description" name="description" value="{{ $session->description }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="unify_id" class="col-sm-2 control-label">Tipo de lista </label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2 required" name="type_list_id" id="type_list_id">
                                            <option value="">-</option>
                                            @foreach($types as $item)
                                            <option value="{{ $item['id'] }}" {{ $session->type_list_id == $item->id ? 'selected="selected"' : '' }} >{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group video d-ids">
                                    <label for="ids" class="col-sm-2 control-label">ID's</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control" name="ids" id="ids" multiple="multiple">
                                            @if ($session->ids)
                                            @foreach($session->ids as $id_item)
                                            <option value="{{ $id_item }}" selected="selected">{{ $id_item }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">URL(genoma.usp.br/)</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control required" id="url" name="url" value="{{ $session->url }}" required>
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        @if ($session->user)
                            <div class="pull-left">
                                <p>{{ $session->updated_at->format('d/m/Y')}} - <span>{{ $session->user->name }}</span></p>
                            </div>
                        @endif
                        <div class="pull-right">
                            <button class="btn btn-info" id="save">Gravar</button>
                            <input type="hidden" name="id" id="id" value="{{ $session->id }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection