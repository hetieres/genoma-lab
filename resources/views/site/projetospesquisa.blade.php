@include('layouts.includes.app-head')
<div class="container">
   <!-- <div class="banner">
        <img src="{{ asset($post->image) }}" class="img-fluid">
    </div>-->
    <br><br>
    <div class="container internal">
        <div class="col-12 col-sm-7 col-md-8 no-padding-left no-padding-xs">
            <h1 class="interal-title" style="padding-top: 0px ;">{{$DadosHead->title}}</h1>
            <h1 class="title-internal">{{$post->title}}</h1>
            <br>
            {!!html_entity_decode(str_replace("\n", "<br>", $post->summary))!!}</em>
            <br><br>
            {!!html_entity_decode($post->text)!!}
        </div>
        <aside class="col-12 col-sm-5 col-md-4 no-padding-right no-padding-xs">
        <div class="addthis_inline_share_toolbox" style="padding-bottom:10px;"></div>
            <div class="titlePesquisa"> <span style="margin-left: 10px;">Linhas de pesquisa do Genoma USP</span>
            </div>
            <br>
            <ul>
                <li><a href="#" class="ListaPesquisa">Busca de variantes responsáveis pela variabilidade clínica da COVID-19</a></li>
                <li><a href="#" class="ListaPesquisa">Genética e envelhecimento saudável</a></li>
                <li><a href="#" class="ListaPesquisa">Genomas das populações brasileiras</a></li>
                <li><a href="#" class="ListaPesquisa">Identificação de genes e mecanismos moleculares de doenças genéticas</a></li>
                <li><a href="#" class="ListaPesquisa">Microbiota humana e genética</a></li>
                <li><a href="#" class="ListaPesquisa">Modelos para terapias de doenças genéticas e medicina regenerativa</a></li>
                <li><a href="#" class="ListaPesquisa">Produção científica</a></li>
            </ul>
    </div>
</div>


<!--
<div class="container">
 
    <h1 class="interal-title">{{$DadosHead->title}}</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="single-recent">
                <div class="card mb-6 shadow-sm">
                    <div class="card-body1 recent-articles-card3 recent-articles-card3-Pesquisa">
                        <p class="TextLimitedProjects" style="color: black; font-weight: 700; text-align: justify;">
                            {{ $post->title }}
                        </p>
                    </div>
                    <div class="card-body">
                        <div >
                            {!!html_entity_decode($post->text)!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
-->
    @include('layouts.includes.app-footer-site')