@php
$Text = "Ciência e tecnologia para o combate à COVID-19";
$English = 0;
$Size = "font-size: 35px;";
@endphp

@if($lang=='en')
@php
$Text = "Science and Technology in the fight against COVID-19";
$English = 1;
$Size = "font-size: 35px;";
@endphp
@endif

<!-- Preloader Start-->
<div id="preloader-active" style="display: block;">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="{{ asset('assets/img/logo/logoGenoma.png') }}" alt="">
            </div>
        </div>
    </div>
</div>
<!-- Preloader Start -->
<!-- Header Start -->
<div id="Removelogos">
    <div class="header-area">
        <div class="main-header ">
            <div class="container">
                <div class="container">
                    <div class="row d-flex align-items-center">
                        <div class="container">
                            <div class="row LabelMobil" style="padding-bottom: 5px;">
                                <div class="col-3" style="border-right: 3px solid #000000;height: 40px;margin-top: 31px;">
                                    <a href="{{ asset('/') . ($lang=="en" ? 'en' : '') }}"><img class="img-fluig" src="{{asset('assets/img/logo/logoGenoma.png') }}" alt="" style="width: 100%;float: right;margin-top: -10px;"></a>
                                </div>
                                <div class="col-md-auto">
                                    <a href="{{ asset('/') . ($lang=="en" ? 'en' : '') }}">
                                        <h1 class="Titulo Titulo2" style="">Centro de Estudos do Genoma Humano e Células-Tronco</h1>
                                    </a>
                                </div>
                                <div class="col-3 painelLogo" >
                                <center style="margin-top: 1px;margin-left: 90px;"> <span style="color: black;font-weight: 500;">&nbsp;</span></center>
                                    <a href="http://www.scs.usp.br/identidadevisual/?page_id=7"><img class="img-fluig logoUSP" src="{{asset('assets/img/logo/usp-logo.png') }}" alt=""></a>
                                    <a href="https://www.ib.usp.br"><img class="img-fluig logo5" src="{{asset('assets/img/logo/logoInstituto.png') }}" alt=""></a>
                                    <a href="https://fapesp.br"><img class="img-fluig LogoFapesp" src="{{asset('assets/img/logo/logo.png') }}" alt=""></a>
                                </div>
                                <div class="col-12" style="text-align: right;">
                                <!--
                                    <a href="https://genoma.ib.usp.br/en" style="position: absolute;top: -5px;right: 0px;">English</a>
-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-line header-sticky" id="DivMenu">
    <div class="container">
        <div class="brand LabelMobil1">
            <a href="{{asset('/') }}" class="link-brand" title="FAPESP - Fundação de Amparo à Pesquisa do Estado de São Paulo">
                <img src="{{asset('assets/img/logo/logoGenoma.png') }}" class="simple img-fluid" alt="logo" />
            </a>

            <a href="javascript:;" class="bars openMenu visible-sm">
                <i class="fas fa-bars"></i>
            </a>
        </div>

        <nav class="menu header2 ">
            <div class="menuMobile visible-sm">
                <span class="title">Menu</span>
                <a href="javascript:;" class="closeMenu">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <a href="{{asset('/') }}"  class="link-brand" title="Genoma">
                <img src="{{asset('assets/img/logo/logo-mini.png') }}"  id="logo-mini" class="simple img-fluid LabelMobil" alt="logo" />
            </a>
            {!! $menu !!}
            <div class="buttons">
                <div class="SearchHide LabelMobil" id="BoxSearch">
                    <form action="{{ route('search' . ($lang=='en' ? '-en' : '')) }}" id="form-search" method="get">
                        <i class="fas fa-search IconeSearch" id="IconeLupa" style="padding-left: 10px;font-size: 25px;"></i>
                        <i class="fas fa-times IconeSearch" style="float: right;padding-right: 20px;" onclick="Show(0)"></i>
                        <input type="text" name="k" class="BoxSearch" autocomplete="off" id="search-input" placeholder="{{$lang=='en' ? 'Search...' : 'Buscar...'}}">
                    </form>
                </div>
                <div class="btnLupa LabelMobil">
                    <i class="fas fa-search IconeSearch" onclick="Show(1)"></i>
                </div>
                <!-- Form para Versão Mobil-->
                <div class="busca LabelMobil11">
                    <form action="/pesquisa" id="form-search" method="get">
                        <button type="submit" class="text-center">
                            <i class="fas fa-search" style="color: white;font-size: 31px;"></i>
                        </button>
                        <input type="text" name="k" id="search-input" placeholder="Buscar...">
                    </form>
                </div>
            </div>
        </nav>
    </div>
</div>
