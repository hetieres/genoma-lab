@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/color-picker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/color-picker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/admin/session-edit.min.js?v=2') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                                    <label for="unify_id" class="col-sm-2 control-label">Tipo destaque </label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2 required" name="type_list_id" id="type_list_id">
                                            <option value="">-</option>
                                            @foreach($types as $item)
                                            <option value="{{ $item['id'] }}" {{ $session->type_list_id == $item->id ? 'selected="selected"' : '' }} >{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group d-ids">
                                    <label for="add_id" class="col-sm-2 control-label">Destaques Home</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" style="width: 200px !important; float: left;" id="add_id" name="add_id" placeholder="ID da matéria">
                                        <a href="#" class="btn btn-success pull-left btn-rel-add">Adicionar</a>
                                        <small style="vertical-align: -webkit-baseline-middle; margin-left: 5px;" id="label_rel"></small>
                                    </div>
                                </div>

                                <div class="form-group d-ids">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-lg-8 col-xs-10">
                                        <ul id="sortable" class="list-group" style="cursor: ns-resize">
                                            @if ($highlight)
                                                @foreach ($highlight as $item)
                                                <li class="list-group-item">
                                                    <small class="label bg-navy" style="font-size: 100%;"><i class="fa fa-fw fa-arrows-v"></i></small>
                                                    <a href="{{ route('detalhe', ['id' => $item->id, 'slug' => str_slug($item->title)]) }}" target="_blank"><small class="label bg-maroon" style="font-size: 100%;"><i class="fa fa-fw fa-eye"></i></small></a>
                                                    <small class="label bg-green" style="font-size: 100%; width: 150px;"><label style="width: 40px;">{{ $item->id }}</label></small>
                                                    <a href="#" class="btn-rel-del"><small class="label bg-red" style="font-size: 100%;"><i class="fa fa-fw fa-remove"></i></small></a>
                                                    {{ $item->title }}
                                                    <input type="hidden" name="ids" value="{{ $item->id }}">
                                                </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">URL(genoma.usp.br/)</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control required" id="url" name="url" value="{{ $session->url }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="color" class="col-sm-2 control-label">Cor </label>
                                    <input type="hidden" name="cor da label da imagem" id="color" class="form-control" value="{{ $session->color }}">
                                    <div class="col-lg-3 col-xs-10 input-group colorize" style="padding-left: 16px;">
                                        <input type="text" name="color" id="color" class="form-control" value="{{ $session->color }}" required>
                                        <div class="input-group-addon"><i></i></div>
                                    </div>
                                </div>

                                <div class="form-group no-video">
                                    <label for="aside" class="col-sm-2 control-label">Menu Lateral</label>
                                    <div class="col-lg-8 col-xs-10">
                                    <textarea class="form-control" rows="15"  id="aside"  name="aside">{{ $session->aside }}</textarea>
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