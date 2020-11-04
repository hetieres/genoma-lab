@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/admin/vehicle-edit-multiple.min.js?v=2') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-automobile"></i> Veículos
            <small>Edição multipla</small>
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
                    @foreach($vehicles as $vehicle)
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ str_pad($vehicle->id, 5, "0", STR_PAD_LEFT) . ' :: ' . $vehicle->description . ' | ' . $vehicle->mediaType->description . ' | ' . $vehicle->from . ' | (' .  $vehicle->news->count() . ' Notícias)'}}</h3>
                    </div>
                    @endforeach
                    <div class="box-body">
                        <form class="form-horizontal" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="unify_id" class="col-sm-2 control-label">Unificar com</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2" name="unify_id" id="unify_id">
                                            <option value="">Nenhum</option>
                                            @foreach($cb_vehicles as $item)
                                            <option value="{{ $item['id'] }}">{{ str_pad($item['id'], 5, "0", STR_PAD_LEFT) . ' - ' . $item['description'] . ' | ' . $item['media']. ' | ' . $item['url'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button class="btn btn-warning" onclick="window.close();">Fechar</button>
                            <button class="btn btn-info" id="save">Gravar</button>
                            <input  type="hidden" name="ids" id="ids" value="{{ $ids }}">
                            <input  type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection