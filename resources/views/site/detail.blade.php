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

</style>

<div class="container">
    <br><br>
    <div class="LabelMobil1">
        <br><br>
    </div>
    <div class="container internal">
        <div class="col-12 col-sm-7 col-md-12 no-padding-left no-padding-xs internal3">
            <h1 class="interal-title" style="padding-top: 0px; color: #000000;">{{ $post->title }}</h1>

            @if ($post->image)
            <div class="internasBanner">
                <center>
                    <img src="{{ $post->getImage() }}" class="internas img-fluid">
                    <small>{{ $post->caption_image }}</small>
                </center>
            </div>
            @endif

            <div class="LabelMobil1"><br></div>


            <br><br>

            {!!html_entity_decode($post->text)!!}
            <br><br>
            <p class="botao"><a href="javascript:history.back()">Voltar</a></p>
        </div>
        {{-- <aside class="col-12 col-sm-5 col-md-4 no-padding-right no-padding-xs">
            {!! str_replace("<div class=\"titlePesquisa\">", "<div class=\"titlePesquisa\" style=\"background: " . $post->session->color . " ;\">", $post->session->aside) !!}
        </aside> --}}
    </div>


    @include('layouts.includes.app-footer-site')