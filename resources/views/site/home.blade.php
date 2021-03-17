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
                        <div class="col-md-4   text-justifid ">
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
                    </div>
                </div>
            </div>
            <div class="BordaInferior2" style="border-bottom: 10px solid #82d643;"></div>
        </div>

        @if ($sessions[0]->posts)
        <div class="recent-articles pt-40 ">
            <div class="container BordaInferior">
                <div class="col-md-12">
                    <div class="section-tittle mb-30">
                        <h3>{{ $sessions[0]->description }}</h3>
                    </div>
                    <div class="row Espaco3">
                        @for ($i = 0; $i < count($sessions[0]->posts); $i++)
                        <div class="col-md Espaco">
                            <div class="single-recent">
                                <a href="{{ $sessions[0]->posts[$i]->link() }}">
                                    <div class=" mb-4" style="height: auto;">
                                        <div class="">
                                            <img src="{{ asset($sessions[0]->posts[$i]->getImage()) }}" alt="" class="img-fluid imgNoticias2">
                                        </div>
                                        <div class="">
                                            <h5 class="cardtitleNoticia subtitulo">{{ $sessions[0]->posts[$i]->title }}</h5>
                                            <p class="TextLimiteNoticias" style="padding-bottom: 50px;">
                                                {!!html_entity_decode(str_replace("\n", "<br>", $sessions[0]->posts[$i]->summary))!!}
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
                    <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => $sessions[0]->url]) }}'">{{ $lang=="pt" ? "Mais" : "More" }}</button>
                </center>
                <br>
            </div>
        </div>
        <div class="BordaInferior2" style="border-bottom: 10px solid {{ $sessions[0]->color }};"></div>
        @endif
    </div>

    @if($sessions[1]->posts)
    <div class="recent-articles pt-40">
        <div class="BordaInferior">
            <div class="recent-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>{{ $sessions[1]->description }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($sessions[1]->posts as $item)
                    <div class="col-md">
                        <div class="single-recent AjusteCaixaMobil">
                            <div class="card mb-4 shadow-sm" style="border: 1px solid #000000;">
                                <a href="{{ $item->link() }}">
                                    <div class="card-body">
                                        <p class="TextLimitedProjects BoxProjeto" >
                                            {{ $item->title }}</p>
                                        <p class="card-text EspacoP" >
                                            {!!html_entity_decode(str_replace("\n", "<br>", $item->summary))!!}
                                        </p>
                                    </div>
                                </a>
                                <!--
                                <a href="{{ asset('/') }}">
                                <img class="img-fluig" src="{{asset('assets/img/seta.png') }}" alt="" style="float: right;margin-right: 10px;"></a>
                           -->
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <br>
            <div class="col-md-12 ">
                <center>
                    <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => $sessions[1]->url]) }}'">{{ $lang=="pt" ? "Mais" : "More" }}</button>
                </center>
                <br>
            </div>

            <br><br>
        </div>
        <div class="BordaInferior2" style="border-bottom: 10px solid {{ $sessions[1]->color }};"></div>
    </div>
    @endif

    @if ($sessions[2]->posts)
    <div class="recent-articles pt-40 ">
        <div class="container BordaInferior">
            <div class="col-md-12">
                <div class="section-tittle mb-30">
                    <h3>{{ $sessions[2]->description }}</h3>
                </div>
                <div class="row Espaco3">
                    @for ($i = 0; $i < count($sessions[2]->posts); $i++) <div class="col-md Espaco">
                        <div class="single-recent">
                            <a href="{{ $sessions[2]->posts[$i]->link() }}">
                                <div class=" mb-4" style="height: auto;">
                                    <div class="">
                                        <img src="{{ asset($sessions[2]->posts[$i]->getImage()) }}" alt="" class="img-fluid imgNoticias">
                                    </div>
                                    <div class="">
                                        <h5 class="cardtitleNoticia subtitulo">{{ $sessions[2]->posts[$i]->title }}</h5>
                                        <p class="TextLimiteNoticias" style="padding-bottom: 50px;">
                                            {!!html_entity_decode(str_replace("\n", "<br>", $sessions[2]->posts[$i]->summary))!!}
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
                <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => $sessions[2]->url]) }}'">{{ $lang=="pt" ? "Mais" : "More" }}</button>
            </center>
            <br>
        </div>
    </div>
    <div class="BordaInferior2" style="border-bottom: 10px solid {{ $sessions[2]->color }};"></div>
    @endif

    @if ($sessions[3]->posts)
        <div class="recent-articles pt-40 ">
            <div class="container">
                <div class="col-md-12">
                    <div class="section-tittle mb-30">
                        <h3>{{ $sessions[3]->description }}</h3>
                    </div>
                    <div class="row Espaco3">
                        @for ($i = 0; $i < count($sessions[3]->posts); $i++)
                        <div class="col-md {{ $i == 0 ? 'Espaco' : 'Espaco5' }}">
                            <div class="single-recent">
                                <a href="{{ $sessions[3]->posts[$i]->link() }}">
                                    <div class=" mb-4" style="height: auto;">
                                        <div class="">
                                            <img src="{{ asset($sessions[3]->posts[$i]->getImage()) }}" alt="" class="img-fluid imgNoticias2">
                                        </div>
                                        <div class="">
                                            <h5 class="cardtitleNoticia subtitulo" style="padding-bottom: 70px;">{{ $sessions[3]->posts[$i]->title }}</h5>
                                            <p class="TextLimiteNoticias">
                                                {!!html_entity_decode(str_replace("\n", "<br>", $sessions[3]->posts[$i]->summary))!!}
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
                <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => $sessions[3]->url]) }}'">{{ $lang=="pt" ? "Mais" : "More" }}</button>
                </center>
                <br>
            </div>
        </div>
    @endif

</div>
</div>




</div>
</main>
@endsection