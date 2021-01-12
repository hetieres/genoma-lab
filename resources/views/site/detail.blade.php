@include('layouts.includes.app-head')

<div class="container">
    <br><br>
    <div class="LabelMobil1">
        <br><br>
    </div>
    <div class="container internal">
        <div class="col-12 col-sm-7 col-md-8 no-padding-left no-padding-xs internal3">
            <h2 class="interal-title" style="padding-top: 0px; color: {{ $post->session->color }};">{{ $post->session->description }}</h2>

            @if ($post->image)
            <div class="internasBanner">
                <center>
                    <img src="{{ $post->getImage() }}" class="internas img-fluid">
                    <small>{{ $post->caption_image }}</small>
                </center>
            </div>
            @endif

            <div class="LabelMobil1"><br></div>
            <!-- Versão Mobil -->
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <div class="addthis_inline_share_toolbox_9yn6 LabelMobil1" style="padding-bottom:10px;float: right;"></div>


            <br><br>

            <h1 class="title-internal2 LabelMobil1">{!! $post->title !!}</h1>
            <!-- FIM -->
            <div class="container LabelMobil">
                <div class="row">
                    <div class="col-sm-9">
                        <h1 class="title-internal2">{!! $post->title !!}</h1>
                    </div>
                    <div class="col-sm-3">
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_inline_share_toolbox_9yn6 " style="padding-bottom:10px;float: right;"></div>
                    </div>
                </div>
            </div>
            <br>
           {{--  {!!html_entity_decode(str_replace("\n", "<br>", $post->summary))!!}--}}</em>
            <br><br>
            {!!html_entity_decode($post->text)!!}
        </div>
        <aside class="col-12 col-sm-5 col-md-4 no-padding-right no-padding-xs">
            {{-- <div class="titlePesquisa"> <span style="margin-left: 10px;">Linhas de pesquisa do Genoma USP</span>
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
            </ul> --}}
            {!! str_replace("<div class=\"titlePesquisa\">", "<div class=\"titlePesquisa\" style=\"background: " . $post->session->color . " ;\">", $post->session->aside) !!}
                    {{-- {!! $post->session->aside !!} --}}

        </aside>
    </div>


    @include('layouts.includes.app-footer-site')