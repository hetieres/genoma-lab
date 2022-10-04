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
        padding: 30px;
        margin: 50px 30px;
    }

    .tabela div.row{
        margin-top: 20px;
    }

    .rotulo{
        text-align: right;
        font-weight: bold;
    }

    input, textarea{
        width: 80%;
        border-radius: 5px;
        border: 1px solid #000;
    }

    #html_element {
        margin-left: auto;
        margin-right: auto;
        width: 304px;
        margin-top: 25px;
    }

    .info {
        color: #31708f;
        background-color: #d9edf7;
        border-color: #bce8f1;
        padding: 20px 50px;
        margin: 0 30px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .pre-text {
        margin: 50px 10px 0px 32px;
        min-height: 350px;
    }

    .input-error{
        border-color: #eb2424;
        background-color: #ffe8e8;
    }



    @media only screen and (max-width: 760px) {

        .tabela{
            padding: 0px;
            margin: 25px 0px;
            border: 0px;
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

        input, textarea{
            width: 100%;
        }

        .info {
            padding: 10px 20px;
            margin: 30px 0px 0;
        }

        .pre-text {
            margin: 0px;
        }

        .pre-text p {
            font-size: 10pt;
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
            <h1 class="interal-title" style="padding-top: 0px; color: #000000;">{{ $title }}</h1>

            <div class="LabelMobil1"><br></div>
            <div class="pre-text">
                {!! $text !!}
            </div>
           <br><br>
        </div>
        {{-- <aside class="col-12 col-sm-5 col-md-4 no-padding-right no-padding-xs">
            {!! str_replace("<div class=\"titlePesquisa\">", "<div class=\"titlePesquisa\" style=\"background: " . $test->session->color . " ;\">", $post->session->aside) !!}
        </aside> --}}
    </div>


    @include('layouts.includes.app-footer-site')
