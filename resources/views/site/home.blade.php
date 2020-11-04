@php($noSearch=false)
@extends('layouts.site')
@section('content')

<div class="row ImgBanner">
    <img src="{{ asset('assets/img/banner/banner.jpg') }}" class="ImgBanner" alt="Fapesp">
</div>

<div class="container">
    <div class="container">
        <div class="recent-articles ">
            <div class="container BordaInferior">
                <div class="recent-wrapper">
                    <div class="row">
                        <div class="col-md-12   text-justifid ">
                            {!!html_entity_decode($pgHome->text)!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-articles pt-40 ">
            <div class="container BordaInferior">
                <div class="recent-wrapper">
                    <div class="row LabelMobil">
                        <div class="col-md-7 " style="cursor: pointer;" onclick="redirectPG('{{ $Noticias[0]->link() }}')" ;>
                            <h4 class="subtitulo">{{ $Noticias[0]->title }}</h4>
                            <p class="TextLimitedNews">{!!$Noticias[0]->dt_publication->format('d/m/Y') . ' &ndash; ' . html_entity_decode($Noticias[0]->summary)!!}</p>
                        </div>
                        <div class="col-md-5 " style="cursor: pointer;" onclick="redirectPG('{{ $Noticias[0]->link() }}')" ;>
                            <img src="{{ asset($Noticias[0]->image) }}" alt="" class="img-fluid imgText">
                        </div>
                    </div>
                    <!-- Versão Mobil -->
                    <div class="row LabelMobil1">
                        <div class="col-md-5 " style="cursor: pointer;" onclick="redirectPG('{{ $Noticias[0]->link() }}')" ;>
                            <img src="{{ asset($Noticias[0]->image) }}" alt="" class="img-fluid imgText">
                        </div>
                        <div class="col-md-7 " style="cursor: pointer;" onclick="redirectPG('{{ $Noticias[0]->link() }}')" ;>
                            <h4 class="subtitulo">{{ $Noticias[0]->title }}</h4>
                            <p class="TextLimitedNews">{!!$Noticias[0]->dt_publication->format('d/m/Y') . ' &ndash; ' . html_entity_decode($Noticias[0]->summary)!!}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 LabelMobil">
                    <div class="row">
                        @for ($i = 1; $i < count($Noticias); $i++) <div class="col-md">
                            <div class="single-recent">
                                <a href="{{ $Noticias[$i]->link() }}">
                                    <div class=" mb-4" style="height: 456px;">
                                        <div class="">
                                            <img src="{{ asset($Noticias[$i]->image) }}" alt="" class="img-fluid imgNoticias">
                                        </div>
                                        <div class="">
                                            <h5 class="cardtitleNoticia subtitulo">{{ $Noticias[$i]->title }}</h5>
                                            <p class="TextLimiteNoticias">
                                                {!!html_entity_decode(str_replace("\n", "<br>", $Noticias[$i]->summary))!!}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="col-md-12 ">
                <center>
                    <button type="button" class="btn btn-primary" onclick="location.href = '{{ route('detalhe', ['slug' => 'noticias']) }}'">Mais Notícias</button>
                </center>
                <br>
            </div>
        </div>
    </div>
    <div class="recent-articles pt-40">
        <div class="container BordaInferior">
            <div class="recent-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>PESQUISAS SOBRE COVID-19 APOIADAS PELA FAPESP</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($tecnologias as $item)
                    <div class="col-md">
                        <div class="single-recent">
                            <a href="{{ $item->link() }}">
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body {{ $item->id == $tecnologias[1]->id ? 'recent-articles-card2' : 'recent-articles-card1' }}">
                                        <p class="TextLimitedProjects" style="color: white; font-weight: 450;">
                                            {{ $item->title }}</p>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">
                                            {!!html_entity_decode(str_replace("\n", "<br>", $item->summary))!!}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 ">
                <center>
                    <button type="button" class="btn btn-primary" onclick="location.href = '{{ route('detalhe', ['slug' => 'projetos-apoiados']) }}'">Conheça todos os projetos</button>
                </center>
                <br>
            </div>
        </div>
    </div>

    <div class="container BordaInferior pt-40 pb-40">
        <div class="recent-wrapper">
            <!-- section Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle mb-30">
                        <h3>PROJETOS DE PESQUISA SOBRE A COVID-19 EM VÍDEOS</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($Videos as $value)
                <div class="col-md">
                    <div class="single-recent">
                        <div class="card mb-5 shadow-sm" style="cursor: pointer;">
                            <div class="card-body" onclick="location.href = '{{  $value->link() }}';">
                                <center>
                                    <img class="ImgTube img-fluid" src="https://img.youtube.com/vi/{{ $value->id_youtube }}/0.jpg" alt="">
                                    <div class="wrapper">
                                        <p class="TextLimited" style="font-size: 17px;">
                                            {{ $value->summary }}
                                        </p>
                                    </div>
                                </center>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12 ">
            <center>
                <button type="button" class="btn btn-primary" onclick=redirectPG("{{ route('videos') }}")>Mais Vídeos</button>
            </center>
            <br>
        </div>
    </div>
</div>

<div class="container BordaInferior pt-40 pb-40">
    <div class="recent-wrapper">
        <!-- section Tittle -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle mb-30">
                    <h3>WEBINARS</h3>
                </div>
            </div>
        </div>
        <div class="row">


            @foreach ($WebiNars as $item)
        
                <div class="col-md">

                    <div class="single-recent">
                        <div class="card mb-5 shadow-sm">
                        <a href="{{ $item->link() }}" style="text-decoration: none;">

                            <div class="card-body1 recent-articles-card4">
                                <p class="TextLimitedProjects" style="color: white; font-weight: 450;height: 90px;margin-bottom: 0px !important;">
                                    {{ $item->title }}
                                </p>
                            </div>
</a>

                            <div class="card-body">
                                <p class="card-title">
                                    {{-- {!!html_entity_decode($item->text)!!} --}}
                                </p>

                                <a href="{{ $item->link() }}" style="text-decoration: none;">
                                <p class="card-text TextLimitedWebNars" style="height: 217px;color: #010201;">
                                    {!!html_entity_decode($item->summary)!!}
                                </p>
                                </a>


                                <center style="margin-top: -20px;">
                                    <button type="button" class="btn btn-primary" onclick="redirectPG('{{ $item->link() }}');">Leia Mais</button>

                                    <?php
                                    if (($item->live != "null" && $item->live != "")) {
                                    ?>
                                        <br>
                                        <input type="button" class="btn3 btn btn-danger btn-sm" onclick="redirectPG('{{ $item->live }}');" value="Live" style="margin-top: 16px;">
                                    <?php
                                    } elseif ($item->id_youtube != "null" && $item->id_youtube != "") {
                                        $urlVideo = "https://www.youtube.com/watch?v=" . $item->id_youtube
                                    ?>
                                    <br>
                                        <input type="button" class="btn4 btn btn-success btn-sm" onclick="redirectPG('{{ $urlVideo }}');" value="Vídeo" style="margin-top: 16px;">

                                    <?php
                                    } else {
                                    ?>
                                    <br><br><br>
                                    <?php
                                    }

                                    ?>


                                </center>
                            </div>
                        </div>
            
        </div>
    </div>
    @endforeach
</div>
</div>
<div class="col-md-12 ">
    <center>
        <button type="button" class="btn btn-primary" onclick=redirectPG("{{ route('webinars') }}")>Todos os Eventos</button>
    </center>
    <br>
</div>
</div>
@endsection