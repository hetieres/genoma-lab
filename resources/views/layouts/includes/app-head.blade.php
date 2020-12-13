<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="{{ app()->getLocale() }}">
<!--<![endif]-->

<head>
 <!-- Go to www.addthis.com/dashboard to customize your tools --> 
 <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5fc6b519332d8fcf"></script>


    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-159627-52');
    </script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Ciência e tecnologia para o combate à COVID-19">
    <meta name="keywords" content="COVID-19, coronavírus, FAPESP, pandemia, epidemia, vírus, vacina, pesquisa, ciência">
    <meta name="author" content="FAPESP">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.baseUrl = "{{ asset('/') }}";
    </script>

    <script>
        function redirect(pg, id) {
            location.href = '/' + pg + '/' + id;
        }

        function redirectPG(pg) {
            location.href = pg;
        }
    </script>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon" />
    <link href="{{ asset('assets/css/site.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/ticker-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles/nice-select.css') }}">
    <link href="{{ asset('assets/css/styles/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/styles/footer.css') }}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/menu/menu.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/js/js/banner/banner.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/js/js/banner/slick.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/js/js/banner/home.min.css')}}" rel="stylesheet">
</head>

<body>
    <header>    
        <!-- Header Start -->
        {{-- Line Bar FAPESP --}}
        @include('layouts.includes.fapesp-bar')
    </header>