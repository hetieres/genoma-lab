@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/js/admin/post-order.min.js') }}"></script>
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
                            <i class="fa fa-fw fa-arrows-v"></i> Destaques
                        </h3>
                        <div class="pull-right">
                            <button class="btn btn-info" id="save">Gravar</button>
                        </div>
                        {{-- <h3 class="box-title">{{ $post->id != '' ? $post->id . ' :: ' . $post->title : '<nova>' }}</h3> --}}
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">

                                {{-- <div class="form-group">
                                    <label for="session_id" class="col-sm-2 control-label">Seção</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2" name="session_id" id="session_id">
                                            <option value=""> - </option>
                                            @foreach($sessions as $session)
                                            <option value="{{ $session['id'] }}" {{ $post->session_id == $session['id'] ? 'selected="selected"' : '' }}>{{ $session['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-lg-12 col-xs-12">
                                    <ul id="sortable" class="list-group">
                                        @foreach ($posts as $item)
                                        <li class="list-group-item">
                                            <div class="label bg-navy" style="height: 75px !important; display: block; width: 75px; font-size: 200%; padding-top: 19px; float: left; margin: 3px;"><i class="fa fa-fw fa-arrows-v"></i></div>
                                            <a href="{{ route('detalhe', ['id' => $item->id, 'slug' => str_slug($item->title)]) }}" target="_blank"><div class="label bg-maroon" style="height: 75px !important; display: block; width: 75px; font-size: 200%; padding-top: 19px;float: left; margin: 3px;"><i class="fa fa-fw fa-eye"></i></div></a>
                                            <a href="#" class="highlight_off"><div class="label bg-red" style="height: 75px !important; display: block; width: 75px; font-size: 200%; padding-top: 19px;float: left; margin: 3px;"><i class="fa fa-fw fa-remove"></i></div></a>
                                            {{-- <a href="#" class="btn-rel-del"><small class="label bg-red" style="font-size: 100%;"><i class="fa fa-fw fa-remove"></i></small></a> --}}
                                            {{-- <img src="{{ asset($item->image) }}" style="height: 50px"> --}}
                                            <img src="{{ asset($item->image) }}" style="height: 75px; width:100px; border-radius: 10px; margin: 3px;">
                                            <label>{{ $item->title }}</label>
                                            <input type="hidden" name="ids" value="{{ $item->id }}">
                                        </li>
                                        @endforeach
                                    </ul>
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
            </div>
        </div>
    </section>
@endsection