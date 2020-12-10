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
                            <div class="row LabelMobil" style="padding-bottom: 15px;">
                                <div class="col-3" style="border-right: 3px solid #000000;height: 40px;margin-top: 31px;">
                                    <a href="{{ asset('/') }}"><img class="img-fluig" src="{{asset('assets/img/logo/logoGenoma.png') }}" alt="" style="width: 100%;float: right;margin-top: -10px;"></a>
                                </div>
                                <div class="col-md-auto">
                                    <a href="{{ asset('/') }}">
                                        <h1 class="Titulo Titulo2" style="">Centro de Estudos do Genoma Humano e Células-Troco</h1>
                                    </a>
                                </div>
                                <div class="col-3" style="margin-left: 30px;">
                                    <a href="{{ asset('/') }}"><img class="img-fluig" src="{{asset('assets/img/logo/logo.png') }}" alt="" style="width: 60%;float: right;margin-top: 20px;"></a>
                                    <a href="{{ asset('/') }}"><img class="img-fluig" src="{{asset('assets/img/logo/logoInstituto.png') }}" alt="" style="float: left;margin-top: 10px;"></a>
                                </div>
                                <div class="col-12" style="text-align: right;">
                                    <!-- <a href="https://covid19.fapesp.br/en">English</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /**
*** Seta para ESQUERDA
**/
    .seta-esquerda:before {
        content: "";
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        width: 0;
        height: 0;

        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        border-right: 5px solid blue;
    }

    /**
*** Seta para DIREITA
**/
    .seta-direita:before {
        content: "";
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        width: 0;
        height: 0;

        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        border-left: 5px solid green;
    }


    

    /**
*** Seta para BAIXO
**/
    .seta-baixo:before {
        content: "";
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        width: 0;
        height: 0;

        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #f00;
    }
</style>


<!--

<a href="#" class="item-menu" id="TST" onclick="Arrow(this.id)"> <i id="arrow_TST" class="fas fa-angle-down ArrowMenu"></i> TESTE</a>
<a href="#" class="item-menu" id="Xuplau" onclick="Arrow(this.id)" > <i id="arrow_Xuplau"  class="fas fa-angle-down ArrowMenu"></i> TESTE1</a>

-->
<!--
<a class="fa fa-angle-double-right" id="Xuplau" href="#"></a>
<a href="#" class="seta-baixo">Seta para cima</a>
-->

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
            <ul class="links" id="navigation">
                <div class="row">
                    <li>
                        <a href="javascript:;" class="LinkMenu"  id="Pesquisa" onclick="Arrow(this.id)">
                            <i class="fas fa-plus visible-sm"></i>
                            <span> <b class="MenuLabel"> <i id="arrow_Pesquisa" class="fas fa-angle-down ArrowMenu LabelMobil"></i> Pesquisa </b></span>
                        </a>
                        <div class="subnav-container">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-5">
                                        <h3 class="b" style="color: white;">
                                            Consultas e aconselhamento genético
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="#">- Doenças neuromusculares</a></li>
                                            <li><a href="#">- Displasias craniofaciais isoladas ou sindrômicas</a></li>
                                            <li><a href="#">- Doenças do desenvolvimento</a></li>
                                            <li><a href="#">- Perda Auditiva genética</a></li>
                                        </ul>

                                        <h3 class="b" style="color: white;border-bottom: none;">
                                            Testes genômicos para diagnóstico
                                        </h3>
                                        <h3 class="b" style="color: white;border-bottom: none;">
                                            Consultoria na área de genômica
                                        </h3>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <h3 class="b" style="color: white;">
                                            Central multiusuários/FAPESP - Análise genômica
                                            <span class="border"></span>
                                        </h3>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <h3 class="b" style="color: white;">
                                                        Sequenciamento Sanger
                                                    </h3>
                                                    <ul class="submenu">
                                                        <li><a href="">- Sequenciamento de produtos de PCR</a></li>
                                                        <li><a href="">- Sequenciamento de plasmídeos</a></li>
                                                        <li><a href="">- Envio de amostras</a></li>
                                                        <li><a href="">- Envio de resultados e preços</a></li>
                                                        <li><a href="">- Cadastro do cliente e formilário</a></li>
                                                        <li><a href="">- Contato</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm">
                                                    <h3 class="b" style="color: white;">
                                                        Sequenciamento de Nova geração (NGS)
                                                    </h3>
                                                    <ul class="submenu">
                                                        <li><a href="#">- Preparo e sequenciamento de bibliotecas</a></li>
                                                        <li><a href="#">- Corridas de sequenciamento de bibliotecas Preparadas pelo pesquisador/cliente</a></li>
                                                        <li><a href="#">- Normas gerais do serviço e submissão das amostras para corridas no CEGH-CEL</a></li>
                                                        <li><a href="#">- Acesso ao serviço</a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:;" class="LinkMenu" id="Servicos" onclick="Arrow(this.id)">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel" style="margin-top: 3px;"><i id="arrow_Servicos" class="fas fa-angle-down ArrowMenu LabelMobil"></i> &nbsp;&nbsp;Serviços</b></span>
                        </a>
                        <div class="subnav-container">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-5">
                                        <h3 class="b" style="color: white;">
                                           TESTE MENU
                                            <span class="border"></span>
                                        </h3>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <h3 class="b" style="color: white;">
                                            Central multiusuários/FAPESP - Análise genômica
                                            <span class="border"></span>
                                        </h3>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:;" id="EnsinoDifusao" onclick="Arrow(this.id)">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel" style="margin-top: 3px;"><i id="arrow_EnsinoDifusao" class="fas fa-angle-down ArrowMenu LabelMobil"></i>&nbsp;&nbsp;Ensino e Difusão</b></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" id="GenomaNumeros" onclick="Arrow(this.id)">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel" style="margin-top: 3px;"><i id="arrow_GenomaNumeros" class="fas fa-angle-down ArrowMenu LabelMobil"></i>&nbsp;&nbsp;Genoma em Números</b></span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" id="QuemSomos" onclick="Arrow(this.id)">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel" style="margin-top: 3px;"><i id="arrow_QuemSomos" class="fas fa-angle-down ArrowMenu LabelMobil"></i>&nbsp;&nbsp;Quem Somos</b> </span>
                        </a>
                    </li>
                    <li class="LabelMobil">
                        <br><br>
                    </li>
                </div>
            </ul>
            <div class="buttons">
                <div class="SearchHide LabelMobil" id="BoxSearch">
                    <form action="/pesquisa" id="form-search" method="get">
                        <i class="fas fa-search IconeSearch" id="IconeLupa" style="padding-left: 10px;"></i>
                        <i class="fas fa-times IconeSearch" style="float: right;padding-right: 10px;" onclick="Show(0)"></i>
                        <input type="text" name="k" class="BoxSearch" autocomplete="off" id="search-input" placeholder="Buscar...">
                    </form>
                </div>
                <div class="btnLupa LabelMobil">
                    <i class="fas fa-search IconeSearch" onclick="Show(1)"></i>
                </div>
                <div class="indices hidden-xs hidden-sm English">
                    <a href="javascript:;" class="text-center">
                        <span style="font-size: 14px;color: #7f7f77;height: 10px;">English&nbsp;</span>
                    </a>
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