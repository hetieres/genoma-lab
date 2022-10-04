@extends('layouts.site')
@section('content')
    <style>

        .search-bar {
            background-color: #ff4a37;
            height: 175px;
            padding:50px;
            width: 90%;
        }


        .grey h3, .search-txt h3{
            font-weight: bold;
            font-size: 18pt;
            padding: 50px 10px;
        }

        .select2-selection.select2-selection--single{
            border: transparent;
            padding: 15px;
            background-color: #243748;
            height: 62px;
            max-width: 707px;
            border-radius: 30px;
        }

        .select2-container{
             display: table-cell;
         }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 48px;
            position: absolute;
            top: 7px;
            color: #ff515b;
            right: 8px;
            background: white;
            width: 50px;
            padding: 0px 13px;
            border-radius: 31px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered{
            color: white;
        }

        .btn-bar{
            margin-top: 90px;
        }

        .btn-bar a{
            background-color: #01538b;
            width: 244px;
            margin-left: 11px;
            display: inline-block;
            height: 120px;
            text-align: center;
            color: white !important;
            padding-top: 30px;
            font-size: 15pt;
        }

        .btn-bar a:hover{
            background-color: #01539b;
        }

        .btn-bar a:first-child{
            margin-left: 0px;
        }

        .btn-bar a:nth-child(even){
            background-color: #0083c3;
        }

        .btn-bar a:nth-child(even):hover{
            background-color: #0083d3;
        }

        .grey{
            background: #eef2f5;
            margin-top: 60px;
            padding: 35px 40px;
        }

        .grey h3::after {
            background: #78BCEE;
            content: "";
            height: 6px;
            width: 110px;
            left: 14px;
            position: absolute;
            top: 40px;
        }

        .grey h5{
            font-weight: 600;
            color: #375ebc;
            font-size: 16px;
            margin-top: 32px;
        }

        .grey p{
            font-size: 15px;
        }
        .grey img{
            width: 100%;
            height: auto;
        }

        summary{
            background: #78BCEE;
            padding: 15px;
            border-radius: 2px;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            margin-top: 4px;
        }

        .col-md-6 details:nth-child(1){
            margin-top: 35px;
        }

        summary:hover{
            background: #4CA5E8;
        }

        details[open] summary {
            background: #274DA8;
        }

        summary::marker {
            content: '';
        }

        details p {
            margin: 10px 20px;
            font-size: 14px;
        }

        .links-uteis{
            margin: 50px 26px 50px 0px !important;
            text-align: center;
            font-size: 13pt;
            color: #5d5d60;
            margin: 0px 33px;
        }

        .links-uteis a{
            color: #5d5d60;
            font-weight: bold;
            margin: 0px 20px;
        }

        .links-uteis a:nth-child(2){
            border-left: solid 2px  #949990;
            padding-left: 40px;
        }

        .links-uteis a:hover{
            color: #000000;
        }

        .links-uteis ul {
            margin-top: 15px;
        }

        .tabela{
                padding: 10px 32px;
        }

        .tabela label, .tabela label b{
            color: #696768;
            margin: 0px 0px 35px 0px;
        }

        .tabela .rrow{
            border-top: 1px solid #cdcdcd;
            padding: 11px 0px;
        }

        .tabela .rrow:hover{
            background: #f5f5f5;
            cursor: pointer;
        }

        .rtitle{
            border-top: 2px solid #cdcdcd !important;
            border-bottom: 1px solid #cdcdcd;
        }

        .ttitle{
            font-weight: bold;
            font-size: 12pt;
            margin: 10px 0px;
            height: 30px;
            top: 3px;
            color: #5d5d60;
        }

        .destaque{
            background-color: ghostwhite;
        }

        .selecionar {
            background: #00774f;
            padding: 10px 15px;
            color: #fff;
            font-weight: bold;
            border-radius: 18px;
        }

        .selecionar:hover {
            background: #048157;
            color: #fff !important;
        }

        .pagination{
            margin: 50px 0 75px;
            padding: 60px 0 0;
            list-style: none;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-top: 4px solid #eaeaea;
            width: 100%;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 10px;
            margin-left: -1px;
            line-height: 1.25;
            color: #428bca;
            background-color: #fff;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #fff;
            background-color: #428bca;
            border-color: #428bca;
        }


        @media only screen and (max-width: 760px) {

        .search-bar {
            height: 130px;
            padding:33px 15px;
            width: 100%;
        }

        .search-txt {
            padding: 30px 15px;
        }

        .select2-selection.select2-selection--single{
            max-width: 300px;
        }

        .btn-bar a:first-child{
            margin-left: 11px;
        }

        .btn-bar{
            margin-top: 20px;
        }

        .btn-bar a{
            width: 90%;
            margin-bottom: 15px;
        }

        .grey {
            padding: 35px 5px;
        }

        .grey .col-md-6 {
            margin-top: 30px;
        }

        .links-uteis ul li{
            padding: 10px 0px;
        }

        .links-uteis a:nth-child(2) {
            border-left: none;
            padding-left: 0px;
        }

        .links-uteis a {
            display: flex;
            margin: 15px 0px;
        }

        .rtitle{
            display: none;
        }

        .tabela .rrow {
            border: 1px solid #cdcdcd;
            padding: 20px 0px;
            margin-top: 20px;
            border-radius: 10px;
        }

        .tabela .rrow div {
            margin: 10px 10px;
        }

        .search-txt h3 {
            padding: 40px 0px 0px 0px;
        }

        .page-link {
            padding: 8px;
        }

        }

    </style>

<div class="container">

    <div class="recent-articles pt-40 ">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-3 search-txt">
                        <h3>Busque exame <br> pela doença ou gene</h3>
                    </div>
                    <div class="col-md-9">
                        <div class="search-bar">
                            <select class="search select2">
                                <option value=""></option>
                                @foreach ($especialidades as $item)
                                    <option value="{!! route('pesquisa') . '?k=e_' . $item->id !!}" {{ (('e_' . $item->id) == $k) ? 'selected' : '' }} >{!! $item->description !!}</option>
                                @endforeach
                                @foreach ($tests as $test)
                                    <option value="{!! $test->link() !!}">{!! $test->test !!}</option>
                                @endforeach
                                @foreach ($genes as $gene)
                                    <option value="{!! route('pesquisa') . '?k=g_' . $gene->id !!}" {{ (('g_' . $gene->id) == $k) ? 'selected' : '' }} >{!! $gene->description !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="links-uteis">
                            <a href="#">Entenda nossos códigos</a>
                            <a href="#">Listas de Genes dos nossos testes</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="recent-articles ">
                <div class="container BordaInferior">
                    <div class="recent-wrapper">
                        <div class="row" style="padding-bottom: 25px;">
                        </div>
                    </div>
                </div>
                <div class="BordaInferior2" style="border-bottom: 10px solid #82d643;"></div>
            </div>

        </div>

        <div class="recent-articles pt-40 ">
            <div class="col-md-12 tabela">
                <label>Foram encontrados <b>{{ $count }}</b> testes.</label>
                <div class="row rtitle">
                    <div class="col-md-2 ttitle">CÓDIGO</div>
                    <div class="col-md-5 ttitle">TESTE</div>
                    <div class="col-md-3 ttitle text-center">VALOR / PRAZO</div>
                    <div class="col-md-2 ttitle"></div>
                </div>
                @foreach ($rs as $item)
                 <div class="row rrow {{ $item->priority == 1 ? 'destaque' : '' }}">
                    <div class="col-md-2">{!! $item->code !!}</div>
                    <div class="col-md-5">{!! implode('<br>', explode(';', $item->test)) !!}</div>
                    <div class="col-md-3 text-center">{!! (substr($item->price, 0, 2) == 'R$' ? '' : 'R$ ') . $item->price !!}<br>Prazo: {!! $item->time !!} dias úteis</div>
                    <div class="col-md-2 text-center mt-15"><a href="{{ $item->link() }}" class="selecionar">Selecionar</a></div>
                </div>
                @endforeach
            </div>
        </div>

         <div class="recent-articles pt-40 ">
            <div class="col-md-12">
                <div class="row">
                
                <ul class="pagination" role="navigation">
                    @if ($lastPage > 5)
                        <li class="page-item previous"><a class="page-link" href="{{ route('pesquisa') . $url . 1 }}"><i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i></a></li>
                        <li class="page-item previous"><a class="page-link" href="{{ route('pesquisa') . $url . ($currentPage - 1 > 0 ? $currentPage - 1 : 1) }}"><i class="fa fa-chevron-left"></i></a></li>
                    @endif
                    @for ($i = 0; $i < count($rangePages); $i++)
                        @if ($currentPage !==  $rangePages[$i])
                            <li class="page-item">
                                <a class="page-link" href="{{ route('pesquisa') . $url . $rangePages[$i] }}">
                                    {{ $rangePages[$i] }}
                                </a>
                            </li>
                        @else
                            <li class="page-item active">
                                <a href="#" class="page-link">
                                    {{ $rangePages[$i] }}
                                </a>
                            </li>
                        @endif
                    @endfor
                    @if ($lastPage > 5)
                        <li class="page-item next"><a class="page-link" href="{{ route('pesquisa') . $url . ($currentPage + 1 > $lastPage ? $lastPage : $currentPage + 1) }}"><i class="fa fa-chevron-right"></i></a></li>
                        <li class="page-item next"><a class="page-link" href="{{ route('pesquisa') . $url . $lastPage }}"><i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></a></li>
                    @endif
                </ul>

                </div>
            </div>
        </div>




</div>
</div>
</div>
</main>

@endsection