@extends('layouts.site')
@section('content')
<main class="Espaco2">
    @if($highlights)
    <section id="banner">
        <div class="slider container">
        @foreach ($highlights as $highlight)
            <div class="slide">
                <div class="image" style="background-image: url('{{ $highlight->getImage() }}')"></div>
                <a href="{{ $highlight->link() }}" class="box">
                    <h2 class="b">{{ $highlight->title }}</h2>
                    <div class="info">{{ $highlight->summary }}</div>
                </a>
            </div>
        @endforeach
        </div>
    </section>
    @endif

<br>
<div class="container">
    <div class="container">
        <div class="recent-articles ">
            <div class="container BordaInferior">
                <div class="recent-wrapper">
                    <div class="row" style="padding-bottom: 25px;">
                        {{-- <div class="col-md-4   text-justifid ">
                            <center>
                            <ul class="social-network social-circle">
                                <li><a href="https://www.facebook.com/genomaUSP/" class="icoFacebook fundoLink" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="https://twitter.com/Mayanazatz" class="icoTwitter fundoLink fundoLink" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="https://www.instagram.com/genoma.usp/" class="icoGoogle fundoLink" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="https://www.youtube.com/c/GenomaUSP" class="icoYouTube fundoLink" title="YouTube"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                            </center>
                        </div>
                        <div class="LabelMobil1">
                            <br><br><br>
                        </div>

                        <div class="col-md" onclick="location.href = 'http://www.genomacovid19.ib.usp.br/';" style="cursor: pointer;">
                            <div class="single-recent" style="margin-left: 0px;margin-right: 0px;width: 85%;">
                                @if ($lang == 'pt')
                                    <div class="card" style="    border: 1px solid #000000;margin-left: 7px; margin-right: -5px;">
                                        <div class="card-body" style="flex: 1 1 auto;padding: 0.5rem;">
                                            <p style="margin-top: 0px;margin-bottom: 0px;">TESTE DE COVID-19 - Saiba como agendar o seu teste molecular rápido
                                                <a href="http://www.genomacovid19.ib.usp.br/"><img class="img-fluig" src="{{asset('assets/img/seta.png') }}" alt="" style="float: right;margin-right: 0px;width: 21px !important;margin-top: 6px;"></a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        --}}
                    </div>
                </div>
            </div>
            <div class="BordaInferior2" style="border-bottom: 10px solid #82d643;"></div>
        </div>

    </div>

    <style>

        .search-bar {
            background-color: #ff4a37;
            height: 175px;
            padding:50px;
            width: 90%;
        }

        .search-txt{
            padding: 50px 40px;
        }

        .grey h3, .search-txt h3{
            font-weight: bold;
            font-size: 18pt;
        }

        .select2-selection.select2-selection--single{
            border: transparent;
            padding: 15px;
            /* background-color: #243748; */
            height: 62px;
            max-width: 707px;
            /* border-radius: 30px; */
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
            color: #000;
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

        .links{
            margin: 30px;
        }

        .links h3{
            font-weight: bold;
        }

        .links a{
            color: #000010;
        }

        .links a:hover{
            color: #000000;
        }

        .links ul {
            margin-top: 15px;
        }

        .links {
            margin: 30px 0px;
        }

        .img_apoio {
            width: 338px !important;
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
            max-width: 279px;
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

        .links ul li{
            padding: 10px 0px;
        }

        .img_apoio {
            width: 100% !important;
        }


        }



    </style>


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
                                    <option value="{!! route('pesquisa') . '?k=e_' . $item->id !!}" >{!! $item->description !!}</option>
                                @endforeach
                                @foreach ($tests as $test)
                                    <option value="{!! $test->link() !!}">{!! $test->test !!}</option>
                                @endforeach
                                @foreach ($tests as $test)
                                    <option value="{!! $test->link() !!}">{!! $test->code !!}</option>
                                @endforeach
                                @foreach ($genes as $gene)
                                    <option value="{!! route('pesquisa') . '?k=g_' . $gene->id !!}" >{!! $gene->description !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-articles pt-40 ">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-3 search-txt mt-70">
                        <h3>Ou escolha uma das opções</h3>
                    </div>
                    <div class="col-md-9 btn-bar">
                        <a href="{{ route('especialidades') }}">TESTES PARA <br> DIAGNÓSTICOS</a>
                        <a href="{{ route('pesquisa') . '?k=e_' . $casais->id }}">TRIAGEM <br>PARA CASAIS</a>
                        <a href="{{ $aconselhamento->link() }}">ACONSELHAMENTO <br> GENÉTICO</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-articles pt-40">
            <div class="col-md-12 ">
                <div class="row grey">
                    <div class="col-md-6">
                        <h3>{!! $sobre->title !!}</h3>
                        <h5>Laboratório de Testes Genéticos do CEGH-CEL</h5>
                        <img src="{{ asset('assets/img/genoma-sobre.png') }}">
                        <p>
                        {!! $sobre->summary !!}
                        </p>
                        <p><a href="{{ $sobre->link() }}">Saiba mais</a></p>
                    </div>
                    <div class="col-md-6" id="duvidas">
                        {{-- <h3 class="mb-50">{!! $duvidas->title !!}</h3>
                        {!! $duvidas->text !!} --}}
                        <p style="text-align: center;">
                            <img src="{{ asset('assets/img/certificacao.jpg') }}" class="img_apoio">
                        </p>
                        <h5>Links Utéis</h5>
                        <ul>
                            <li><a href="https://genoma.ib.usp.br/198">Serviços de genômica para pesquisadores e empresas</a></li>
                            <li><a href="#">Listas de Genes dos nossos testes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="recent-articles pt-40 ">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-4">
                         <img src="{{ asset('assets/img/certificacao.jpg') }}" class="img_apoio">
                    </div>
                    <div class="col-md-8">
                        <div class="links">
                            <h3>Links Utéis</h3>
                            <ul>
                                <li><a href="https://genoma.ib.usp.br/198">Serviços de genômica para pesquisadores e empresas</a></li>
                                <li><a href="#">Listas de Genes dos nossos testes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

</div>
</div>
</div>
</main>

<div id="modalPage" aria-labelledby="Label" role="dialog" tabindex="-1" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Título</h4>
            </div>

            <div class="modal-body"></div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>

@endsection