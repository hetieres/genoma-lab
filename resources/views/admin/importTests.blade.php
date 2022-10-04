@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/js/admin/import-test.min.js') }}"></script>
@endsection

@section('content')
    {{-- <section class="content-header">
        <h1>
            <i class="fa fa-fw fa-file-o"></i> Matéria
            <small>Edição</small>
        </h1>
    </section> --}}

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-fw fa-table"></i> Testes Genéticos
                        </h3>
                        {{-- <h3 class="box-title">{{ $post->id != '' ? $post->id . ' :: ' . $post->title : '<nova>' }}</h3> --}}
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="file" class="col-sm-2 control-label">Excel</label>
                                    <div class="col-lg-6 col-xs-8">
                                        <input type="file" class="form-control" id="file" name="file">
                                    </div>
                                </div>

                                <div class="text-red text-center load d-none">
                                    <img class="loading" src="{{ asset('assets/img/loading.svg') }}" style="width: 100%; height: 200px;">
                                </div>

                                <div class="success d-none">
                                    <h2>Sucesso:</h2>
                                    <p>127 registros atualizados.</p>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button class="btn btn-info" id="save">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection