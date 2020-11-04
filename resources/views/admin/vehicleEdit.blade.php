@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/admin/vehicle-edit.min.js?v=2') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-automobile"></i> Veículo
            <small>Edição</small>
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
                        <h3 class="box-title">{{ $vehicle->id != '' ? $vehicle->id . ' :: ' . $vehicle->description : '<novo>' }}</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Veiculo</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control required" id="description" name="description" value="{{ $vehicle->description }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="unify_id" class="col-sm-2 control-label">Mídia</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2 required" name="media_type_id" id="media_type_id">
                                            <option value="">-</option>
                                            @foreach($medias as $item)
                                            <option value="{{ $item['id'] }}" {{ $vehicle->media_type_id == $item->id ? 'selected="selected"' : '' }} >{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="country_id" class="col-sm-2 control-label">País</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2 required" name="country_id" id="country_id">
                                            <option value="">-</option>
                                            <option value="367">Não Identificado</option>
                                            @foreach($countries as $country)
                                                @if ($country->id != 367)
                                                    <option value="{{ $country['id'] }}" {{ $vehicle->country_id == $country['id'] ? 'selected="selected"' : '' }} >{{ $country['description'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group d-state">
                                    <label for="citation_type_id" class="col-sm-2 control-label">Estado</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2" name="state" id="state">
                                            <option value=""> - </option>
                                            <option value="Não Identificado">Não Identificado</option>
                                            @foreach($states as $state)
                                                @if ($state->state != 'Não Identificado')
                                                    <option value="{{ $state->state }}" {{ $vehicle->state == $state->state ? 'selected="selected"' : '' }}>{{ $state->state }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group d-city">
                                    <label for="city" class="col-sm-2 control-label">Cidade</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="city" name="city" value="{{ $vehicle->city }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">URL</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="url" name="url" value="{{ $vehicle->url }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="big" class="col-sm-2 control-label">Grande Imprensa</label>
                                    <div class="col-lg-2  col-xs-6">
                                        <input type="checkbox"{{ $vehicle->big == 1 ? 'checked="checked"'  : ''}} id="big" name="big">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="limited_access" class="col-sm-2 control-label">Conteúdo Restrito</label>
                                    <div class="col-lg-2  col-xs-6">
                                        <input type="checkbox"{{ $vehicle->limited_access == 1 ? 'checked="checked"'  : ''}} id="limited_access" name="limited_access">
                                    </div>
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label for="status_vehicle_id" class="col-sm-2 control-label">Status</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2 required" name="status_vehicle_id" id="status_vehicle_id">
                                            <option value="">-</option>
                                            @foreach($status as $item)
                                            <option value="{{ $item['id'] }}" {{ $vehicle->status_vehicle_id == $item['id'] ? 'selected="selected"' : '' }} >{{ $item['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="unify_id" class="col-sm-2 control-label">Unificar com</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2" name="unify_id" id="unify_id">
                                            <option value="">-</option>
                                            @foreach($vehicles as $item)
                                                @if ($item->id != $vehicle->id)
                                                    <option value="{{ $item->id }}" {{ $vehicle->unify_id == $item->id ? 'selected="selected"' : '' }} >{{ $item->description . ' | ' . $item->media . ' | ' . $item->url . ' | (' .  $item->total . ' Notícias)'  }}</option>
                                                @endif
                                            @endforeach
                                        </select><br>
                                        <small>* selecione veículo valido/correto para unificar com veículo importado</small>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        @if ($vehicle->user)
                            <div class="pull-left">
                                <p>{{ $vehicle->updated_at->format('d/m/Y')}} - <span>{{ $vehicle->user->name }}</span></p>
                            </div>
                        @endif
                        <div class="pull-right">
                            <button class="btn btn-warning" onclick="window.close();">Fechar</button>
                            <button class="btn bg-maroon btn-view" onclick="window.open('{{  route('details', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id]) }}','_blank')" {{ $vehicle->news_total > 0 ? '' : 'disabled="disabled"' }}>Visualizar</button>
                            <button class="btn btn-info" id="save">Gravar</button>
                            <input type="hidden" name="id" id="id" value="{{ $vehicle->id }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection