@include('layouts.includes.app-head')
<style>
    .internal3 h1::after {
        background: #78BCEE;
        content: "";
        height: 6px;
        width: 110px;
        left: 0px;
        position: absolute;
        top: 40px;
    }

    .internal3 h3 {
        display: flex;
    }

    .internal3 h3::after {
        background: #78BCEE;
        content: "";
        height: 6px;
        width: 110px;
        position: absolute;
        margin: 42px 0px;
    }

    .internal3 .botao {
        text-align: center;
        width:100%;
    }

    .internal3 .botao a{
        background-color: #78bcee;
        color: #fff;
        padding: 10px 30px;
        font-weight: bold;
        text-align: center;
    }

    .internal3 .botao a:hover{
        background-color: #78cfee;
        color: #fff!important;
    }

    .btn-bar{
            margin-top: 0px;
    }

    .btn-bar a{
        background-color: #0083c3;
        width: 266px;
        margin-left: 11px;
        display: inline-grid;
        height: 120px;
        text-align: center;
        color: white !important;
        padding-top: 30px;
        font-size: 15pt;
        margin-top: 11px
    }

    .btn-bar a:hover{
        background-color: #0083d3;
    }

    @media only screen and (max-width: 760px) {

        .btn-bar a{
            width: 90%;
            padding: 15px;
            height: auto;
        }

        }

</style>

<div class="container">
    <br><br>
    <div class="LabelMobil1">
        <br><br>
    </div>
    <div class="container internal">
        <div class="col-12 col-sm-7 col-md-12 no-padding-left no-padding-xs internal3">
            <h1 class="interal-title" style="padding-top: 0px; color: #000000;">Especialidades Médicas</h1>

            <br><br>
            <div class="btn-bar">
                @foreach ($especialidades as $item)
                    <a href="{{ route('pesquisa') . '?k=e_' . $item->id }}">{{ $item->description }}</a>
                @endforeach
            </div>
            <br><br>
            <p class="botao"><a href="{{ route('home')}}">Voltar</a></p>
        </div>
        {{-- <aside class="col-12 col-sm-5 col-md-4 no-padding-right no-padding-xs">
            {!! str_replace("<div class=\"titlePesquisa\">", "<div class=\"titlePesquisa\" style=\"background: " . $post->session->color . " ;\">", $post->session->aside) !!}
        </aside> --}}
    </div>


    @include('layouts.includes.app-footer-site')