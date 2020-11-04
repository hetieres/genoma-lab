@php($noSearch=true)
@extends('layouts.site')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ asset('assets/css/pages/search.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@endsection

@section('content')
    <main class="container internal">
        <h1>
            <span>Coronavírus</span>
            <ul class="breadcrumbs">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active"><span>Coronavírus</span></li>
            </ul>
        </h1>

        <div class="col-12 col-sm-8 col-md-12 no-padding-left no-padding-xs">
            <!--
            <div class="searchLine margin-bottom-30">
                <div id="searchBox">
                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Digite sua busca..." value="{{ isset($_GET['k']) ? $_GET['k'] : '' }}">
                    <button id="searchBtn" type="button"><i class="fa fa-search"></i></button>
                    @if(isset($_GET['k']) && trim($_GET['k'])!=='') <button id="searchClear" type="button"><i class="fa fa-times"></i></button> @endif
                </div>

                <div id="searchOrder" class="hidden-xs">
                    <label for="order">Ordernar por:</label>
                    <select name="order" id="orderning" class="form-control">
                        <option value="1" {{ isset($_GET['o']) && $_GET['o'] == 1 ? 'selected="selected"' : '' }}>Relevância</option>
                        <option value="2" {{ isset($_GET['o']) && $_GET['o'] == 2 ? 'selected="selected"' : '' }}>Mais Recentes</option>
                        <option value="3" {{ isset($_GET['o']) && $_GET['o'] == 3 ? 'selected="selected"' : '' }}>Mais Antigas</option>
                    </select>
                </div>
            </div>
            -->

            <h2 class="infoCorona">
                <span>{{ number_format($rs->total(), 0, ',', '.') }} notícias, página {{ number_format($currentPage, 0, ',', '.') }} de {{  number_format($lastPage, 0, ',', '.') }}</span>
            </h2>

            <ul class="newsList">
                @foreach ($rs as $news)
                    <li>
                        <h3><a href="{{ route('details', ['title' => str_slug($news->title), 'id' => $news->id]) }}">{{ $news->title }}</a></h3>
                        <div class="datePublic">
                            <a href="{{ route('details', ['title' => str_slug($news->vehicle->description), 'id' => $news->vehicle->id]) }}">{{ $news->vehicle->description }}</a>
                             - Publicado em {{ $news->dt_publication->formatLocalized('%d %B %Y') }}
                        </div>
                        <div class="description">{!! \App\Helpers\BaseHelper::limitChar($news->text)  !!}</div>
                    </li>
                @endforeach
            </ul>

            <ul class="pagination" role="navigation">
                @if ($lastPage > 5)
                    <li class="previous"><a href="{{ route('coronavirus') . $url . ($currentPage - 1 > 0 ? $currentPage - 1 : 1) }}"><i class="fa fa-chevron-left"></i> Anterior</a></li>
                @endif

                @for ($i = 0; $i < count($rangePages); $i++)
                    @if ($currentPage !==  $rangePages[$i])
                        <li class="page-item">
                            <a class="page-link" href="{{ route('coronavirus') . $url . $rangePages[$i] }}">
                                {{ $rangePages[$i] }}
                            </a>
                        </li>
                    @else
                        <li class="page-item active">
                            <span>
                                {{ $rangePages[$i] }}
                            </span>
                        </li>
                    @endif
                @endfor

                @if ($lastPage > 5)
                    <li class="next"><a href="{{ route('coronavirus') . $url . ($currentPage + 1 > $lastPage ? $lastPage : $currentPage + 1) }}">Próximo <i class="fa fa-chevron-right"></i></a></li>
                @endif
            </ul>
        </div>

        {{-- @include('site.includes.aside-coronavirus') --}}
    </main>
@endsection