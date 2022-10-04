@if (isset($li) && $li)
    <li class="list-group-item">
        <small class="label bg-navy" style="font-size: 100%;"><i class="fa fa-fw fa-arrows-v"></i></small>
        <a href="{{ route('detalhe', ['id' => $post->id, 'slug' => str_slug($post->title)]) }}" target="_blank"><small class="label bg-maroon" style="font-size: 100%;"><i class="fa fa-fw fa-eye"></i></small></a>
        <small class="label bg-green" style="font-size: 100%; width: 150px;"><label style="width: 40px;">{{ $post->id }}</label></small>
        <a href="#" class="btn-rel-del"><small class="label bg-red" style="font-size: 100%;"><i class="fa fa-fw fa-remove"></i></small></a>
        {{ $post->title }}
        <input type="hidden" name="ids" value="{{ $post->id }}">
    </li>
    @php
        die();
    @endphp
@endif

@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('assets/js/admin/post-edit.min.js?v=' . config('app.version')) }}"></script>
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
            <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Edição</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Uploads</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Versões</a></li>
              {{-- <li class="pull-right"><a href="{{ route('geral', ['id' => $post->id, 'slug' => str_slug($post->title)]) }}" target="_blank"><small class="label bg-maroon" style="font-size: 100%;"><i class="fa fa-fw fa-eye"></i></small></a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                     {{-- <div class="col-xs-12"> --}}
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-fw fa-file-o"></i> {{ ($post->id != '' ? $post->id . ' :: ' . $post->title : 'Matéria <nova>') }}
                            {{-- <small>Edição</small> --}}
                        </h3>
                        {{-- <h3 class="box-title">{{ $post->id != '' ? $post->id . ' :: ' . $post->title : '<nova>' }}</h3> --}}
                        <div class="pull-right">
                            <button class="btn bg-maroon btn-view" onclick="window.open('{{ route('detalhe', ['title' => str_slug($post->title), 'id' => $post->id]) }}','_blank')" {{ $post->id == '' ? 'disabled="disabled"' : '' }}>Visualizar</button>
                            <button class="btn btn-success btn-copy" {{ $post->id == '' ? 'disabled="disabled"' : '' }}>Copiar URL</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="session_id" class="col-sm-2 control-label">Seção</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control select2" name="session_id" id="session_id">
                                            <option value=""> - </option>
                                            @foreach($sessions as $session)
                                            <option value="{{ $session['id'] }}" {{ $post->session_id == $session['id'] ? 'selected="selected"' : '' }}>{{ $session['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Título</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control required" id="title" name="title" value="{{ $post->title }}" >
                                    </div>
                                </div>

                                <div class="form-group no-content">
                                    <label for="summary" class="col-sm-2 control-label">Resumo</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <textarea class="form-control" rows="4"  id="summary">{{ $post->summary }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group no-content no-video">
                                    <label for="href" class="col-sm-2 control-label">Redirecionamento</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="href" name="href" value="{{ $post->href }}" >
                                    </div>
                                </div>

                                <div class="form-group no-video">
                                    <label for="text" class="col-sm-2 control-label">Texto</label>
                                    <div class="col-lg-8 col-xs-10">
                                    <textarea class="form-control" rows="15"  id="text"  name="text">{{ $post->text }}</textarea>
                                    </div>
                                </div>
{{-- 
                                <div class="form-group no-content no-video">
                                    <label for="href" class="col-sm-2 control-label">Live</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="live" name="live" value="{{ $post->live }}" >
                                    </div>
                                </div>

                                <div class="form-group video">
                                    <label for="id_youtube" class="col-sm-2 control-label">ID Youtube</label>
                                    <div class="col-lg-4 col-xs-10">
                                        <select class="form-control" name="id_youtube" id="id_youtube" multiple="multiple">
                                            @if ($post->id_youtube)
                                            <option value="{{ $post->id_youtube }}" selected="selected">{{ $post->id_youtube }}</option>
                                            @endif
                                        </select>
                                        <div class="youtube-preview" style="margin-top: 15px;">
                                            @if ($post->id_youtube)
                                            <img src="https://img.youtube.com/vi/{{ $post->id_youtube }}/mqdefault.jpg" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="form-group">
                                    <label for="dt_publication" class="col-sm-2 control-label">Publicado</label>
                                    <div class="col-lg-2  col-xs-7 input-group date" style="padding-left: 15px;">
                                        <input type="text" class="form-control pull-right date required" id="dt_publication" value="{{ $post->dt_publication != '' ? $post->dt_publication->format('d/m/Y') : '' }}">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group no-content">
                                    <label for="highlight" class="col-sm-2 control-label">Destaque Home</label>
                                    <div class="col-lg-2  col-xs-6">
                                        <input type="checkbox"{{ $post->highlight == 1 ? 'checked="checked"'  : ''}} id="highlight" name="highlight">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="active" class="col-sm-2 control-label">Ativo</label>
                                    <div class="col-lg-2  col-xs-6">
                                        <input type="checkbox"{{ $post->active == 1 ? 'checked="checked"'  : ''}} id="active" name="highlight">
                                    </div>
                                </div>

                                <div class="form-group img no-video no-content">
                                    <label for="image" class="col-sm-2 control-label">Imagem</label>
                                    <div class="col-lg-6 col-xs-8">
                                        <input type="file" class="form-control" id="image" name="image">
                                        <input type="hidden" id="flag-img" value="{{ $post->image != '' ? 1 : 0  }}">
                                    </div>
                                </div>

                                <div class="form-group img-view {{ $post->image == '' ? 'd-none' : ''  }} no-video no-content">
                                    <label class="col-sm-2 control-label"></label>
                                    <div>
                                        <img class="col-lg-4 col-xs-6" src="{{ $post->image }}" alt=""><a class="btn btn-warning" id="del-image">Excluir imagem</a>
                                    </div>
                                </div>

                                <div class="form-group  img-view {{ $post->image == '' ? 'd-none' : ''  }} no-video no-content">
                                    <label for="caption_image" class="col-sm-2 control-label">Créditos imagem</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <input type="text" class="form-control" id="caption_image" name="caption_image" value="{{ $post->caption_image }}" >
                                    </div>
                                </div>


                                <div class="form-group no-content">
                                    <label for="keywords" class="col-sm-2 control-label">Keywords (SEO)</label>
                                    <div class="col-lg-8 col-xs-10">
                                        <select class="form-control" name="keywords" id="keywords" multiple="multiple">
                                            @if ($post->keywords)
                                                @foreach($post->keywords as $key)
                                                    <option value="{{ $key }}"  selected="selected">{{ $key }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                        @if ($post->user)
                            <div class="pull-left">
                                <p>{{ $post->updated_at->format('d/m/Y h:i:s')}} - <span>{{ $post->user->name }}</span></p>
                            </div>
                        @endif
                        <div class="pull-right">
                            <button class="btn bg-maroon btn-view" onclick="window.open('{{ route('detalhe', ['title' => str_slug($post->title), 'id' => $post->id]) }}','_blank')" {{ $post->id == '' ? 'disabled="disabled"' : '' }}>Visualizar</button>
                            <button class="btn btn-success btn-copy" {{ $post->id == '' ? 'disabled="disabled"' : '' }}>Copiar URL</button>
                            <button class="btn btn-danger" id="del" {{ $post->id == '' ? 'disabled="disabled"' : '' }}>Excluir</button>
                            <button class="btn btn-info" id="save">Gravar</button>
                            <input type="hidden" name="id" id="id" value="{{ $post->id }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                            <input type="hidden" name="url_copy" id="url_copy" value="{{ route('detalhe', ['title' => str_slug($post->title), 'id' => $post->id]) }}">
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
              </div>
              <!-- /.tab-pane -->



              <div class="tab-pane" id="tab_2">
                <div class="box">
                    {{-- <div class="box-header with-border">
                        <h3 class="box-title">Upload de arquivos</h3>
                    </div> --}}
                    <div class="box-body">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="files" class="col-sm-2 control-label">Arquivos</label>
                                    <div class="col-lg-6 col-xs-8">
                                        <input type="file" multiple="multiple" class="form-control" id="files" name="files[]">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="box-footer">
                         <div class="row">
                            @foreach ($files as $file)
                                <div class="col-lg-2 col-xs-4">
                                    <div class="file-item">
                                        @if($file['icon'] == false)
                                            <img  src="{{ $file['url'] }}" width="100"  alt="">
                                        @else
                                            <i class="fa fa-fw {{ $file['icon'] }}"></i>
                                        @endif
                                            <p>{{ $file['basename'] }}</p>
                                            <input type="hidden" id="url" value="{{ $file['url'] }}">
                                            <button class="btn btn-danger upload-del" >Excluir</button>
                                            <button class="btn btn-info upload-copy">Copiar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
              </div>

              <div class="tab-pane" id="tab_3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Histórico de versões</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th style="width: 70%">Título/Comentário</th>
                                    <th>Atualizado</th>
                                    <th>Ações</th>
                                </tr>
                                @foreach ($post->history as $item)
                                    <tr class="{{ $history_id == $item->history_id ? 'active' : '' }}">
                                        <td>{{ $item->history_id }}</td>
                                        <td>{{ $item->title }}<br>{{ $item->comment }}</td>
                                        <td>{{ $item->user ? $item->user->name : '' }}<br>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a class="label bg-maroon" alt="Editar" href="{{ route('post-comparation', ['id' => $item->id, 'history_id' => $item->history_id]) }}" style="font-size: 100% !important"><i class="fa fa-fw fa-clone"></i></a>
                                            <a class="label bg-green" alt="Editar" href="{{ route('post-edit', ['id' => $item->id, 'history_id' => $item->history_id]) }}" style="font-size: 100% !important"><i class="fa fa-fw fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>



        </div>
    </section>
@endsection