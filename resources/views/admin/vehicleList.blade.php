@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/css/users.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script>
        // $(document).ready(function(){

        //     $('#cb_country, #cb_status').change(function (){
        //         $('#btn-submit').click();
        //     });

        //     $('#key').keypress(function(e) {
        //         if(e.which == 13) {
        //             $('#btn-submit').click();
        //         }
        //     });

        //     function getCookie(name){
        //         var pattern = RegExp(name + "=.[^;]*")
        //         matched = document.cookie.match(pattern)
        //         if(matched){
        //             var cookie = matched[0].split('=')
        //             return cookie[1]
        //         }
        //         return ''
        //     }

        //     $('#cb_status').val(getCookie('c_status_vehicle_id'));
        //     $('#cb_status').trigger('change');

        //     $('#cb_country_id').val(getCookie('c_country_id'));
        //     $('#cb_country_id').trigger('change');

        //     $('#key').val(getCookie('c_key'));

        // });
    </script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-automobile"></i> Veículos
            <small>Lista Veículos</small>
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
            <em-vehicles></em-vehicles>
        </div>
    </section>
@endsection