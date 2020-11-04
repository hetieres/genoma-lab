@php
$Text = "Ciência e tecnologia para o combate à COVID-19";
$English = 0;
$Size = "font-size: 35px;";
@endphp

@if(isset($post->id) && $post->id == "294" )
@php
$Text = "Science and Technology in the fight against COVID-19";
$English = 1;
$Size = "font-size: 35px;";
@endphp

@endif



<!-- Preloader Start-->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Preloader Start -->
<!-- Header Start -->

<div>
    <div class="header-area">
        <div class="main-header ">
            <div class="container">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="container">
                            <div class="row LabelMobil">
                                <div class="col-3">
                                    <a href="http://www.fapesp.br/"><img src="https://covid19.fapesp.br/assets/img/logo/logo.jpg" alt="" style="margin-bottom: -5px;"></a>
                                </div>
                                <div class="col-md-auto">

                                    <a href="https://covid19.fapesp.br/">
                                        <h1 class="Titulo" style="margin-top: 18px;font-size: 35px; ">Ciência e tecnologia para o combate à COVID-19</h1>
                                    </a>
                                </div>
                                <div class="col-12" style="text-align: right;">
                                                                        <a href="https://covid19.fapesp.br/en">English</a>
                                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-8 col-md-12">
                            <!-- sticky -->
                            <div class="sticky-logo">
                                <div class="row">
                                    <div class="col-2">
                                        <a href="http://www.fapesp.br/"><img src="https://covid19.fapesp.br/assets/img/logo/logoBranco.jpg" alt="" style="margin-top: 0px;width: 100px; margin-left: 0px;"></a>
                                    </div>
                                    <div class="col-8">
                                        <center>
                                            <a href="{{ asset('/') }}">
                                                <h1 class="TitleSite">Ciência e tecnologia para o combate à COVID-19</h1>
                                            </a>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <!-- Main-menu -->
                            <div class="main-menu d-none d-md-block">
                                                                <nav>
                                    <ul id="navigation">
                                        <li><a href="{{ asset('/') }}projetos-apoiados" style="text-decoration: none;"> Projetos apoiados</a>
                                            <ul class="submenu">
                                                <li><a href="{{ asset('/') }}projetos-apoiados/suplementos">Suplementos de Rápida Implementação</a></li>
                                                <li><a href="{{ asset('/') }}projetos-apoiados/tecnologias">Desenvolvimento de Tecnologias</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ asset('/') }}noticias">Notícias</a></li>
                                        <li><a href="{{ asset('/') }}comunicados">Comunicados</a></li>
                                        <li><a href="{{ asset('/') }}videos">Vídeos</a></li>
                                        <li><a href="{{ asset('/') }}webinars">Webinars</a></li>
                                        <li><a href="https://repositoriodatasharingfapesp.uspdigital.usp.br/" target="_blank">COVID-19 Data Sharing/BR</a></li>

                                        <li class="search">
                                            <form action="{{ asset('/') }}pesquisa" id="form-search" method="get">
                                                <div class="input-group md-form form-sm form-1 pl-0">
                                                    <input type="text" class="form-control my-0 py-1 InputSearch InputSearch" name="k" id="searchInput" placeholder="Buscar..." aria-label="Search">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text purple lighten-3 IconSearch" id="basic-text1">

                                                            <button type="submit" name="searchBtn" id="searchBtn" style="border:none;background: none;">
                                                                <i class="fas fa-search text-white" aria-hidden="true"></i>
                                                        </span>
                                                        </button>

                                                    </div>
                                                </div>
                                            </form>
                                            <div class="LabelMobil1">
                                                <a href="{{ asset('/') }}en" style="border: none;color: #004aff;">English</a>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                                                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-md-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($English == "1" )
<div class="row ImgBanner">
    <img src="{{ asset('assets/img/banner/banner.jpg') }}" class="ImgBanner" alt="Fapesp">
</div>
@endif