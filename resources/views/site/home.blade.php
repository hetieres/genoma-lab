@extends('layouts.site')
@section('content')
<main class="Espaco2">
    <section id="banner">
        <div class="slider container">
            <div class="slide">
                <div class="image" style="background-image: url('https://fapesp.br/files/home/34571.jpg')"></div>
                <a href="https://agencia.fapesp.br/ipen-se-equipa-para-produzir-nanorradiofarmacos/34571/" class="box" target="_blank">
                    <h2 class="b">Ipen se equipa para produzir nanorradiofármacos</h2>
                    <div class="info">Com apoio da FAPESP, laboratório de padrão internacional associa nanotecnologia e radiofarmácia para desenvolver novos produtos, principalmente para o tratamento de câncer</div>
                </a>
            </div>
            <div class="slide">
                <div class="image" style="background-image: url('https://fapesp.br/files/home/cpe2.jpg')"></div>
                <a href="https://fapesp.br/14600/fapesp-e-gsk-anunciam-chamada-para-constituicao-do-centro-de-novos-alvos-terapeuticos-em-oncologia" class="box">
                    <h2 class="b">FAPESP e GSK anunciam chamada para Centro de Novos Alvos Terapêuticos em Oncologia</h2>
                    <div class="info">Novo centro realizará pesquisas fundamentais e aplicadas buscando descobrir novos alvos terapêuticos para o tratamento do câncer</div>
                </a>
            </div>
            <div class="slide">
                <div class="image" style="background-image: url('https://fapesp.br/files/home/34543.jpg')"></div>
                <a href="https://agencia.fapesp.br/oito-emendas-ao-pl-627-buscam-assegurar-transferencias-do-tesouro-a-fapesp-em-2021/34543/" class="box" target="_blank">
                    <h2 class="b">Oito emendas ao PL 627 buscam assegurar transferências do Tesouro à FAPESP em 2021</h2>
                    <div class="info">Uma das emendas foi apresentada em conjunto pelos seis deputados que integram a Comissão de Ciência, Tecnologia, Inovação e Informação da Alesp</div>
                </a>
            </div>
            <div class="slide">
                <div class="image" style="background-image: url('https://fapesp.br/files/home/054-058-avaliacoes-297-0-1140.jpg')"></div>
                <a href="https://revistapesquisa.fapesp.br/impactos-da-pesquisa-na-sociedade/" class="box" target="_blank">
                    <h2 class="b">Impactos da pesquisa na sociedade</h2>
                    <div class="info">Levantamento aponta resultados positivos em programas da FAPESP de apoio a pequenas empresas, colaborações internacionais e formação de pesquisadores</div>
                </a>
            </div>
        </div>
    </section>
</main>
<br>
<div class="container">
    <div class="container">
        <div class="recent-articles ">
            <div class="container BordaInferior">
                <div class="recent-wrapper">
                    <div class="row" style="padding-bottom: 25px;">
                        <div class="col-md-5   text-justifid ">
                            <ul class="social-network social-circle">
                                <li><a href="#" class="icoFacebook fundoLink" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="icoTwitter fundoLink fundoLink" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="icoGoogle fundoLink" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#" class="icoYouTube fundoLink" title="YouTube"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                        <div class="LabelMobil1">
                            <br><br><br>
                        </div>
                        <div class="col-md">
                            <div class="single-recent" style="margin-left: 0px;margin-right: 0px;width: 85%;">
                                <div class="card" style="    border: 1px solid #000000;margin-left: 7px; margin-right: -5px;">
                                    <div class="card-body" style="flex: 1 1 auto;padding: 0.5rem;">
                                        <p style="margin-top: 0px;margin-bottom: 0px;">ESTÁGIO - para atuar em Educação em Difusão do Genoma
                                            <a href="{{ asset('/') }}"><img class="img-fluig" src="{{asset('assets/img/seta.png') }}" alt="" style="float: right;margin-right: 15px;width: 25px;"></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="BordaInferior2" style="border-bottom: 10px solid #82d643;"></div>
        </div>

        <div class="recent-articles pt-40 ">
            <div class="container BordaInferior">
                <div class="col-md-12">
                    <div class="section-tittle mb-30">
                        <h3>Conheça o Genoma</h3>
                    </div>
                    <div class="row Espaco3">
                        @for ($i = 0; $i < count($Noticias); $i++) <?php
                                                                    if ($i == 0) {
                                                                        $style = "Espaco";
                                                                    } else {
                                                                        $style = "Espaco5";
                                                                    }
                                                                    ?> <div class="col-md {{$style}}">
                            <div class="single-recent">
                                <a href="{{ $Noticias[$i]->link() }}">
                                    <div class=" mb-4" style="height: auto;">
                                        <div class="">
                                            <img src="{{ asset($Noticias[$i]->image) }}" alt="" class="img-fluid imgNoticias2">
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
                    <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => 'noticias']) }}'">Saiba mais</button>
                </center>
                <br>
            </div>
        </div>
        <div class="BordaInferior2" style="border-bottom: 10px solid #00b9e4;"></div>
    </div>

    <div class="recent-articles pt-40">
        <div class="container BordaInferior">
            <div class="recent-wrapper">
                <!-- section Tittle -->
                <div class="row Espaco3">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>Projetos de Pesquisa</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($projetos as $item)
                    <div class="col-md">
                        <div class="single-recent">
                            <div class="card mb-4 shadow-sm" style="border: 1px solid #000000;">
                                <a href="{{ $item->link() }}">
                                    <div class="card-body">
                                        <p class="TextLimitedProjects" style="color: #1e359c;font-weight: 450;height: 120px;">
                                            {{ $item->title }}</p>
                                        <p class="card-text" style="height: 105px;">
                                            {!!html_entity_decode(str_replace("\n", "<br>", $item->summary))!!}
                                        </p>
                                    </div>
                                </a>
                                <a href="{{ asset('/') }}">
                                <img class="img-fluig" src="{{asset('assets/img/seta.png') }}" alt="" style="float: right;margin-right: 10px;"></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 ">
                <center>
                    <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => 'projetos-apoiados']) }}'">Mais pesquisas</button>
                </center>
                <br>
            </div>
        </div>
        <div class="BordaInferior2" style="border-bottom: 10px solid #f6303e;"></div>
    </div>
    <div class="recent-articles pt-40 ">
        <div class="container BordaInferior">
            <div class="col-md-12">
                <div class="section-tittle mb-30">
                    <h3>Educação e Difusão</h3>
                </div>
                <div class="row Espaco3">
                    @for ($i = 0; $i < count($EducacaoDifusao); $i++) <div class="col-md Espaco">
                        <div class="single-recent">
                            <a href="{{ $EducacaoDifusao[$i]->link() }}">
                                <div class=" mb-4" style="height: auto;">
                                    <div class="">
                                        <img src="{{ asset($EducacaoDifusao[$i]->image) }}" alt="" class="img-fluid imgNoticias">
                                    </div>
                                    <div class="">
                                        <h5 class="cardtitleNoticia subtitulo">{{ $EducacaoDifusao[$i]->title }}</h5>
                                        <p class="TextLimiteNoticias">
                                            {!!html_entity_decode(str_replace("\n", "<br>", $EducacaoDifusao[$i]->summary))!!}
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
                <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => 'noticias']) }}'">Mais</button>
            </center>
            <br>
        </div>
    </div>
    <div class="BordaInferior2" style="border-bottom: 10px solid #0032a0;"></div>
</div>
</div>
<div class="container">
        <div class="recent-articles pt-40 ">
            <div class="container">
                <div class="col-md-12">
                    <div class="section-tittle mb-30">
                        <h3>Conheça o Genoma</h3>
                    </div>
                    <div class="row Espaco3">
                        @for ($i = 0; $i < count($Midia); $i++) <?php
                                                                    if ($i == 0) {
                                                                        $style = "Espaco";
                                                                    } else {
                                                                        $style = "Espaco5";
                                                                    }
                                                                    ?> <div class="col-md {{$style}}">
                            <div class="single-recent">
                                <a href="{{ $Midia[$i]->link() }}">
                                    <div class=" mb-4" style="height: auto;">
                                        <div class="">
                                            <img src="{{ asset($Midia[$i]->image) }}" alt="" class="img-fluid imgNoticias2">
                                        </div>
                                        <div class="">
                                            <h5 class="cardtitleNoticia subtitulo">{{ $Midia[$i]->title }}</h5>
                                            <p class="TextLimiteNoticias">
                                                {!!html_entity_decode(str_replace("\n", "<br>", $Midia[$i]->summary))!!}
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
                <button type="button" class="ButtonG" onclick="location.href = '{{ route('detalhe', ['slug' => 'noticias']) }}'">Mais</button>
                </center>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection