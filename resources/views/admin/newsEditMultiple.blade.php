@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/js/admin/news-edit-multiple.min.js?v=2') }}"></script>
    <script>var json_news = {!! $json_news !!}; </script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-files-o"></i> Notícias
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
                    @foreach ($news as $item)
                        <div class="box-header with-border" id="title_{{ $item->id }}">
                            <h3 class="box-title"><i class="fa fa-fw fa-file-o"></i> {{ $item->id . ' :: ' . $item->title . ' | ' . $item->vehicle->description }}</h3>
                        </div>
                    @endforeach
                    <div class="box-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Título</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $news[0]->title }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tags" class="col-sm-2 control-label">Tags</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control select2" multiple="multiple" data-placeholder="Selecione tags" name="tags" id="tags" style="width: 100%;">
                                            @foreach($tags as $tag)
                                            <option value="{{ $tag['id'] }}" {{  in_array($tag['id'], $news[0]->tags) ? 'selected="selected"' : '' }}>{{ $tag['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category_id" class="col-sm-2 control-label">Categoria</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2" name="category_id" id="category_id">
                                            <option value=""> - </option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}" {{ $news[0]->category_id == $category['id'] ? 'selected="selected"' : '' }}>{{ $category['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="author" class="col-sm-2 control-label">Autor</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="author" name="author" value="{{ $news[0]->author }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="url_fapesp" class="col-sm-2 control-label">URL Fapesp</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="url_fapesp" name="url_fapesp" value="{{ $news[0]->url_fapesp }}">
                                    </div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label for="summary" class="col-sm-2 control-label">Chamada</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <textarea class="form-control" rows="4"  id="summary">{{ $news[0]->summary }}</textarea>
                                    </div>
                                </div>
                                -->
                                <div class="form-group">
                                    <label for="text" class="col-sm-2 control-label">Texto</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <button type="button" class="btn btn-default btn-md col-lg-4 col-xs-10" disabled="disabled" id="prev">Anterior</button>
                                                <button type="button" class="btn btn-default btn-md col-lg-4 col-xs-10" id="remove">Remover da Edição :: {{ $news[0]->id }}</button>
                                                <button type="button" class="btn btn-default btn-md col-lg-4 col-xs-10" id="next">Próximo</button>
                                             </div>
                                        </div>
                                        <textarea class="form-control" rows="15"  id="text"  name="text">{{ $news[0]->text }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="news_status_id" class="col-sm-2 control-label">Status</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2" name="news_status_id" id="news_status_id">
                                            <option value=""> - </option>
                                            @foreach($status as $item)
                                            <option value="{{ $item['id'] }}" {{ $news[0]->news_status_id == $item['id'] ? 'selected="selected"' : '' }}>{{ $item['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="citation_type_id" class="col-sm-2 control-label">Tipo de citação</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2" name="citation_type_id" id="citation_type_id">
                                            <option value=""> - </option>
                                            @foreach($citations as $citation)
                                            <option value="{{ $citation['id'] }}" {{ $news[0]->citation_type_id == $citation['id'] ? 'selected="selected"' : '' }}>{{ $citation['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="number_process" class="col-sm-2 control-label">N. Processo FAPESP</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control" name="number_process" id="number_process" multiple="multiple">
                                            @if ($news[0]->number_process)
                                                @foreach($news[0]->number_process as $number)
                                                    <option value="{{ $number }}"  selected="selected">{{ $number }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="number_researcher" class="col-sm-2 control-label">N. Pesquisador</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control" name="number_researcher" id="number_researcher" multiple="multiple">
                                            @if ($news[0]->number_researcher)
                                                @foreach($news[0]->number_researcher as $number)
                                                    <option value="{{ $number }}"  selected="selected">{{ $number }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button class="btn btn-warning" onclick="window.close();">Fechar</button>
                            <button class="btn btn-success btn-copy">Copiar Link's</button>
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