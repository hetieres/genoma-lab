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
        display: inline-block;
        width: 23%;
        margin: 10px;
    }

    .internal3 .botao a:hover{
        background-color: #78cfee;
        color: #fff!important;
    }

    .tabela{
        border: 1px solid;
        border-radius: 5px;
        padding: 30px 30px 60px;
        margin: 50px 30px;
    }

    .tabela div.row{
        margin-top: 20px;
    }

    .rotulo{
        text-align: right;
        font-weight: bold;
    }



    @media only screen and (max-width: 760px) {

        .tabela{
            padding: 30px 30px;
            margin: 50px 0px;
        }

        .rotulo{
            text-align: left;
            margin-top: 20px;
        }

        .internal3 .botao a{
            width: 95%;
        }

        .tabela div.row:nth-child(1){
            margin-top: 0;
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
            <h1 class="interal-title" style="padding-top: 0px; color: #000000;padding-bottom: 50px;">{{ $test->code }}</h1>

            <div class="LabelMobil1"><br></div>

            <div class="tabela">

                <div class="row">
                    <div class="col-md-4 rotulo">Código</div>
                    <div class="col-md-8">{{ $test->code }}</div>
                </div>

                <div class="row">
                    <div class="col-md-4 rotulo">Doença(s)</div>
                    <div class="col-md-8">{!! implode('<br>', explode(';', $test->test)) !!}</div>
                </div>

                <div class="row">
                    <div class="col-md-4 rotulo">Descrição</div>
                    <div class="col-md-8">{{ $test->description }}</div>
                </div>

                @if ($test->note)
                <div class="row">
                    <div class="col-md-4 rotulo">Observação</div>
                    <div class="col-md-8">{{ $test->note }}</div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-4 rotulo">Gene / Região</div>
                    <div class="col-md-8">{{ $test->genes }}</div>
                </div>

                <div class="row">
                    <div class="col-md-4 rotulo">TUSS</div>
                    <div class="col-md-8">{{ $test->tuss }}</div>
                </div>

                <div class="row">
                    <div class="col-md-4 rotulo">Prazo de entrega</div>
                    <div class="col-md-8">{{ $test->time }} dias úteis</div>
                </div>

                <div class="row">
                    <div class="col-md-4 rotulo">Preço</div>
                    <div class="col-md-8">{{ $test->price }}</div>
                </div>

            </div>

            <p class="botao"><a href="{{ route('solicitacao', $test->id) }}">Solicitar o Exame</a><a href="javascript:history.back()">Voltar</a></p>

            <br><br>
        </div>
        {{-- <aside class="col-12 col-sm-5 col-md-4 no-padding-right no-padding-xs">
            {!! str_replace("<div class=\"titlePesquisa\">", "<div class=\"titlePesquisa\" style=\"background: " . $test->session->color . " ;\">", $post->session->aside) !!}
        </aside> --}}
    </div>


    @include('layouts.includes.app-footer-site')
