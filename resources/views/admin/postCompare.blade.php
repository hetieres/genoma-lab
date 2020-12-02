@extends('layouts.app')
@section('styles')
@endsection

@section('scripts')
@endsection

@section('content')
   <section class="content-header">
      <h1>
            <i class="fa fa-fw fa-columns"></i> Versionamento
            <small>Diferenças entres versões</small>
      </h1>
   </section>

   <section class="content">
      <div class="row">
         <div class="col-md-6">
            <div class="box box-solid">
               <div class="box-header with-border">
                  <i class="fa fa-calendar-minus-o"></i>
                  <h3 class="box-title"> Versão {{ $version2->history_id }} <small>{{ $version2->created_at->format('d/m/Y H:i:s') }}</small></h3>
                  <div class="pull-right">
                     <button class="btn bg-green"  onclick="window.location.href='{{ $version2->url_edit }}'"><i class="fa fa-fw fa-edit"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->prev }}'" {{ $version1->prev ? '' : 'disabled'}}><i class="fa fa-fw fa-step-backward"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->next }}'" {{ $version1->next ? '' : 'disabled'}}><i class="fa fa-fw fa-step-forward"></i></button>
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  {!! $version2->htmlDiff !!}
               </div>
               <!-- /.box-body -->
               <div class="box-footer">
                  <div class="pull-right">
                     <button class="btn bg-green"  onclick="window.location.href='{{ $version2->url_edit }}'"><i class="fa fa-fw fa-edit"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->prev }}'" {{ $version1->prev ? '' : 'disabled'}}><i class="fa fa-fw fa-step-backward"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->next }}'" {{ $version1->next ? '' : 'disabled'}}><i class="fa fa-fw fa-step-forward"></i></button>
                  </div>
               </div>
            </div>
            <!-- /.box -->
         </div>
         <!-- ./col -->
         <div class="col-md-6">
            <div class="box box-solid">
               <div class="box-header with-border">
                  <i class="fa fa-calendar-plus-o"></i>
                  <h3 class="box-title"> Versão {{ $version1->history_id }} <small>{{ $version1->created_at->format('d/m/Y H:i:s') }}</small></h3>
                  <div class="pull-right">
                     <button class="btn bg-green"  onclick="window.location.href='{{ $version1->url_edit }}'"><i class="fa fa-fw fa-edit"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->prev }}'" {{ $version1->prev ? '' : 'disabled'}}><i class="fa fa-fw fa-step-backward"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->next }}'" {{ $version1->next ? '' : 'disabled'}}><i class="fa fa-fw fa-step-forward"></i></button>
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                  {!! $version1->htmlDiff !!}
               </div>
               <!-- /.box-body -->
               <div class="box-footer">
                  <div class="pull-right">
                     <button class="btn bg-green"  onclick="window.location.href='{{ $version1->url_edit }}'"><i class="fa fa-fw fa-edit"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->prev }}'" {{ $version1->prev ? '' : 'disabled'}}><i class="fa fa-fw fa-step-backward"></i></button>
                     <button class="btn bg-maroon" onclick="window.location.href='{{ $version1->next }}'" {{ $version1->next ? '' : 'disabled'}}><i class="fa fa-fw fa-step-forward"></i></button>
                  </div>
            </div>
            </div>
            <!-- /.box -->
         </div>
         <!-- ./col -->
      </div>
   </section>
@endsection