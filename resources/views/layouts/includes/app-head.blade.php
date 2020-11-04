<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="{{ app()->getLocale() }}">
<!--<![endif]-->

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159627-52"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
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
    <!-- CSRF Token -->
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
</head>

<body>
    <header>
        <!-- Header Start -->
        {{-- Line Bar FAPESP --}}
        @include('layouts.includes.fapesp-bar')
    </header>
    
   