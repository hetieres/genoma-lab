@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/css/users.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js" async defer></script>
    <script src="{{ asset('assets\vendor\highcharts\highcharts.js') }}"></script>
    <script src="{{ asset('assets\vendor\highcharts\exporting.js') }}"></script>
    <script src="{{ asset('assets\vendor\highcharts\export-data.js') }}"></script>
    <script src="{{ asset('assets\js\admin\news-report.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-fw fa-th"></i> Relatórios
            <small>Conjunto de relatórios x filtros</small>
        </h1>
        <!--
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><i class="fa fa-users"></i> Usuários</li>
        </ol>
        -->
    </section>

    <section class="content">
        <div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtros</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Status</label>
                            <select class="form-control select2" name="cb_status" id="cb_status" multiple="multiple">
                                @foreach ($status as $item)
                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Mídia</label>
                            <select class="form-control select2" name="cb_media" id="cb_media" multiple="multiple">
                                @foreach ($media as $item)
                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Categoria</label>
                            <select class="form-control select2" name="cb_category" id="cb_category" multiple="multiple">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Período</label>
                            <input type="text" class="form-control" id="daterange" name="daterange">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Limite de resultado</label>
                            <select class="form-control select2" name="cb_limit" id="cb_limit">
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cb_type_vehicle">Tipo Veículo</label>
                            <select class="form-control select2" name="cb_type_vehicle" id="cb_type_vehicle">
                                    <option value="0">Todos</option>
                                    <option value="1">Nacionais</option>
                                    <option value="2">Internacionais</option>
                                    <option value="3">Grande Imprensa</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tipo de citação</label>
                            <select class="form-control select2" id="cb_citation" multiple="multiple">
                                @foreach ($citations as $citation)
                                    <option value="{{ $citation->id }}">{{ $citation->description }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Veículo</label>
                            <select class="form-control select2" id="cb_vehicle" multiple="multiple">
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->description }} </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Palavra chave</label>
                            <input type="text" class="form-control" id="key" name="key" placeholder="Palavra chave">
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="key">Palavra chave</label>
                            <input type="text" class="form-control" id="key" name="key" placeholder="Palavra chave">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-left">
                        <p class="help-block"></p>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-default btn-clear">Limpar</button>
                        <button class="btn btn-info pull-right btn-filter">Filtrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-red text-center load">
            <img class="loading" src="{{ asset('assets/img/loading.svg') }}"  style="width: 100%; height: 200px;"/>
        </div>

        <div class="done d-none">
            <div class="box">
                <div class="print" style="background-color: white;">
                    <div class="box-header">
                        <h3 class="box-title">Notícias mais repercutidas - por assunto</h3>
                        <small class="filter"></small>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Título</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table1">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="#" class="btn btn-info pull-right btn-download">Download</a>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="done d-none">
            <div class="box">
                <div class="print" style="background-color: white;">
                    <div class="box-header">
                        <h3 class="box-title">Notícias mais repercutidas - por url</h3>
                        <small class="filter"></small>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Título</th>
                                    <th>URL</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table2">

                            </tbody>
                            </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="#" class="btn btn-info pull-right btn-download">Download</a>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="done d-none">
            <div class="box">
                <div class="print" style="background-color: white;">
                    <div class="box-header">
                        <h3 class="box-title">Veículos por repercussão</h3>
                        <small class="filter"></small>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">Código</th>
                                    <th>Veículo</th>
                                    <th>Origem</th>
                                    <th>Mídia</th>
                                    <th>URL</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table4">

                            </tbody>
                            </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="#" class="btn btn-info pull-right btn-download">Download</a>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="done d-none">
            <div class="row">
                <div class="col-xs-6">
                    <div class="box">
                        <div id="container1"></div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="box">
                        <div id="container2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="done d-none">
            <div class="box">
                <div class="print" style="background-color: white;">
                    <div class="box-header">
                        <h3 class="box-title">Lista de Notícias</h3>
                        <small class="filter"></small>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Título</th>
                                    <th>Veículo</th>
                                    <th>Origem</th>
                                    <th>URL</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody class="table3">

                            </tbody>
                            </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <a href="#" class="btn btn-success pull-right btn-download">Download Excel</a>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="done d-none">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div id="container3"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection