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
                                <div class="col-3" style="border-right: 3px solid #000000;height: 40px;margin-top: 20px;">
                                    <a href="{{ asset('/') }}"><img class="img-fluig" src="{{asset('assets/img/logo/logoGenoma.png') }}" alt="" style="width: 85%;float: right;margin-top: -5px;"></a>
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

            <!--
            <div class="header-bottom header-sticky ">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-8 col-md-12">
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
                        </div>
                    </div>
                </div>
            </div>
-->
        </div>
    </div>
</div>


<div class="menu-line header-sticky">
    <div class="container">
        <div class="brand LabelMobil1">
            <a href="{{asset('/') }}" class="link-brand" title="FAPESP - Fundação de Amparo à Pesquisa do Estado de São Paulo">
                <img src="{{asset('assets/img/logo/logoGenoma.png') }}" class="simple img-fluid" alt="logo" />
            </a>

            <a href="javascript:;" class="bars openMenu visible-sm">
                <i class="fas fa-bars"></i>
            </a>
        </div>

        <nav class="menu header2 " >
            <div class="menuMobile visible-sm">
                <span class="title">Menu</span>
                <a href="javascript:;" class="closeMenu">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="links" id="navigation">
                <div class="row">
                    <li>
                        <a href="javascript:;">
                            <i class="fas fa-plus visible-sm "></i>
                            <span><b class="MenuLabel">Fomento à </b></span>
                        </a>
                        <div class="subnav-container">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <h3 class="b">
                                            Bolsas
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="bolsas/ic">Iniciação Científica</a></li>
                                            <li><a href="bolsas/ms">Mestrado</a></li>
                                            <li><a href="bolsas/dr">Doutorado</a></li>
                                            <li><a href="bolsas/dd">Doutorado Direto</a></li>
                                            <li><a href="bolsas/pd">Pós-Doutorado</a></li>
                                            <li><a href="bolsas/bepe">Estágio de Pesquisa no Exterior (BEPE)</a></li>
                                            <li><a href="bolsas/bpe">Pesquisa no Exterior (BPE)</a></li>
                                            <li><a href="ensinopublico">Ensino Público</a></li>
                                            <li><a href="bolsas/tt">Treinamento Técnico</a></li>
                                            <li class="more"><a href="bolsas"><b>+ Veja mais</b></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <h3 class="b">
                                            Auxílios
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="apr">Regular</a></li>
                                            <li><a href="tematico">Projeto Temático</a></li>
                                            <li><a href="jp">Jovens Pesquisadores</a></li>
                                            <li><a href="147/auxilios">Pesquisador Visitante</a></li>
                                            <li><a href="156/auxilios">Organização de Reunião Científica</a></li>

                                            <li class="more"><a href="auxilios"><b>+ Veja mais</b></a></li>
                                        </ul>

                                        <h3 class="b">
                                            Programas
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="bioen">BIOEN</a></li>
                                            <li><a href="biota">BIOTA</a></li>
                                            <li><a href="escience">ESCIENCE</a></li>
                                            <li><a href="pfpmcg">Mudanças Climáticas</a></li>
                                            <li class="more"><a href="programas"><b>+ Veja mais</b></a></li>
                                        </ul>

                                    </div>
                                    <div class="col-12 col-md-3">
                                        <h3 class="b">
                                            Submissão de Propostas
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="13628">Como Submeter Propostas</a></li>
                                            <li><a href="analise">Sistemática de Análise</a></li>
                                            <li><a href="valores">Valores Praticados pela FAPESP</a></li>
                                        </ul>
                                        <h3 class="b">
                                            Execução de Processos
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="13632">Execução de Processos</a></li>
                                            <li><a href="prestacaodecontas">Uso de Recursos e Prestação de Contas</a></li>
                                            <li><a href="financeiro">Liberação de Recursos </a></li>
                                            <li><a href="importacao">Importação e Exportação</a></li>
                                            <li><a href="565">Alterações da Concessão</a></li>
                                            <li><a href="570">Submissão de Relatórios Científicos</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <h3 class="b">
                                            Sistemas
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="https://sage.fapesp.br/SAGe_WEB/jsp/loginAdm.jsp">SAGe</a></li>
                                            <li><a href="cadastroagilis">Agilis</a></li>
                                            <li><a href="https://siaf.fapesp.br/">SIAF</a></li>
                                        </ul>
                                        <h3 class="b">
                                            Outros Links
                                            <span class="border"></span>
                                        </h3>
                                        <ul class="submenu">
                                            <li><a href="avaliacao">Avaliação de Programas</a></li>
                                            <li><a href="5913">Consulta aos Dados da Instituição</a></li>
                                            <li><a href="faq">Dúvidas Frequentes</a></li>
                                            <li><a href="eaip">Escritório de Apoio (EAIP)</a></li>
                                            <li><a href="gestaodedados">Gestão de Dados</a></li>
                                            <li><a href="assessores">Informações para Assessores</a></li>
                                            <li><a href="pontosdeapoio">Pontos de Apoio</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>


                    <li>
                        <a href="javascript:;">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel">Pesquisa para</b></span>
                        </a>
                        <div class="dropnav-container">

                            <div class="row">
                                <div class="col-12 ">
                                    <h3 class="b">
                                        Programas
                                        <span class="border"></span>
                                    </h3>
                                    <ul class="submenu">
                                        <li><a href="3740/programas">Apoio à Propriedade Intelectual (PAPI)</a></li>
                                        <li><a href="http://fapesp.br/cpe/" target="_blank">Centro de Pesquisa em Engenharia / Centro de Pesquisa Aplicada</a></li>
                                        <li><a href="http://cepid.fapesp.br/home/" target="_blank">Centros de Pesquisa, Inovação e Difusão (CEPID)</a></li>
                                        <li><a href="http://www.fapesp.br/pipe/" target="_blank">Pesquisa Inovativa em Pequenas Empresas (PIPE)</a></li>
                                        <li><a href="61/auxilios">Pesquisa em Parceria para Inovação Tecnológica (PITE)</a></li>
                                    </ul>
                                    <br>
                                    <h3 class="b">
                                        Resultados

                                        <span class="border"></span>
                                    </h3>
                                    <ul class="submenu">
                                        <li><a href="http://pesquisaparainovacao.fapesp.br/" target="_blank">Boletim Pesquisa para Inovação</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel">Difusão do</b></span>
                        </a>
                        <div class="dropnav-container">
                            <div class="col-12">
                                <h3 class="b">
                                    Impacto da Pesquisa na Sociedade
                                    <span class="border"></span>
                                </h3>
                                <ul class="submenu">
                                    <li><a href="https://agencia.fapesp.br" target="_blank">Agência FAPESP</a></li>
                                    <li><a href="https://bv.fapesp.br" target="_blank">Biblioteca Virtual</a></li>
                                    <li><a href="https://cienciaaberta.fapesp.br" target="_blank">Ciência Aberta</a></li>
                                    <li><a href="https://www.youtube.com/playlist?list=PLPdNbZy8nSthxPuBXifoSDlFOTmT4Ja5w" target="_blank">Ciência SP</a></li>
                                    <li><a href="https://covid19.fapesp.br" target="_blank">COVID-19</a></li>
                                    <li><a href="eventos">Eventos</a></li>
                                    <li><a href="https://namidia.fapesp.br" target="_blank">FAPESP na Mídia</a></li>
                                    <li><a href="6222">Imprensa</a></li>
                                    <li><a href="publicacoes">Publicações e Exposições</a></li>
                                    <li><a href="http://pesquisaparainovacao.fapesp.br/" target="_blank">Pesquisa para Inovação</a></li>
                                    <li><a href="https://revistapesquisa.fapesp.br/" target="_blank">Revista Pesquisa FAPESP</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel">Boas Práticas</b></span>
                        </a>
                        <div class="dropnav-container">
                            <div class="col-12">
                                <h3 class="b">
                                    Boas Práticas e Políticas
                                    <span class="border"></span>
                                </h3>
                                <ul class="submenu">
                                    <li><a href="boaspraticas">Boas Práticas Científicas</a></li>
                                    <li><a href="gestao-de-dados">Gestão de Dados</a></li>
                                    <li><a href="http://www.fapesp.br/openscience/" target="_blank">Open Science</a></li>
                                    <li><a href="12632">Política para Acesso Aberto</a></li>
                                    <li><a href="pi">Política para Propriedade Intelectual </a></li>
                                    <li><a href="daip">Diretrizes para Apoio Administrativo Institucional à Pesquisa</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="fas fa-plus visible-sm"></i>
                            <span><b class="MenuLabel">Sobre a</b> </span>
                        </a>

                        <div class="dropnav-container">
                            <div class="row" style="width: 520px;">
                                <div class="col-12 col-md-6">
                                    <h3 class="b">
                                        Missão
                                        <span class="border"></span>
                                    </h3>
                                    <ul class="submenu">
                                        <li><a href="2/institucional">A FAPESP</a></li>
                                        <li><a href="6">Estratégias de Fomento à Pesquisa</a></li>
                                        <li><a href="381/institucional">Estatísticas e Balanços</a></li>
                                        <li><a href="12183/transparencia">Transparência</a></li>
                                    </ul>
                                    <br>
                                    <h3 class="b">
                                        Estrutura
                                        <span class="border"></span>
                                    </h3>
                                    <ul class="submenu">
                                        <li><a href="4/institucional">Conselho Superior e Diretoria</a></li>
                                        <li><a href="1479/institucional">Coordenações</a></li>
                                    </ul>
                                    <br>
                                    <h3 class="b">
                                        Histórico
                                        <span class="border"></span>
                                    </h3>
                                    <ul class="submenu">
                                        <li><a href="28">Criação e Estruturação</a></li>
                                        <li><a href="https://bv.fapesp.br/linha-do-tempo/">Linha do Tempo</a></li>
                                    </ul>
                                    <br>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h3 class="b">
                                        Colaborações em Pesquisa
                                        <span class="border"></span>
                                    </h3>
                                    <ul class="submenu">
                                        <li><a href="6883/cooperacao">Cooperação internacional</a></li>
                                        <li><a href="sprint">SPRINT</a></li>
                                        <li><a href="http://www.fapesp.br/acordos/" target="_blank">Mapa de cooperações</a></li>
                                        <li><a href="chamadas">Chamadas de Propostas</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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