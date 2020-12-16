@php($noSearch=false)
@extends('layouts.site')

@section('styles')
    <link href="{{ asset('assets/css/pages/vehicles.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages/home.min.js') }}"></script>
@endsection

@section('content')
    <main class="container internal">
        <h1>
            <span>Veículo</span>
            <ul class="breadcrumbs">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('vehicles') }}">Veículos</a></li>
                <li class="active"><span>{{ $vehicle->description }}</span></li>
            </ul>
        </h1>

        <div class="col-12 col-sm-8 col-md-9 no-padding-left no-padding-xs">
            <div class="vehiclesHighlights">
                <div class="boxTitle">
                    <div class="boxVehicleBig">
                        {{ $vehicle->description }}
                    </div>

                    <div class="total">
                        <h5><b>Em {{ $year }}:</b> {{$vehicle->total_year }} notícias</h5>
                        <h5><b>Desde 1995:</b> {{$vehicle->total }} notícias</h5>
                    </div>
                </div>

                @if(count($news))
                    <a href="{{ route('detalhe', ['title' => str_slug($news[0]->title), 'id' => $news[0]->id]) }}">
                        <h4>{{ $news[0]->title }}</h4>
                    </a>

                    <div class="lastPublic">
                        Publicado em {{ $news[0]->dt_publication->formatLocalized('%d %B %Y') }}
                        {{-- @if (count($news[0]->source) == 3)
                            | <a href="{{ $news[0]->source['url'] }}" class="text-{{ $news[0]->source['class'] }}" target="_blank">{{ $news[0]->source['name'] }}</a>
                        @endif --}}
                    </div>

                    <a href="{{ route('detalhe', ['title' => str_slug($news[0]->title), 'id' => $news[0]->id]) }}">
                        <div class="description">{!! $news[0]->summary != '' ? strip_tags($news[0]->summary) : \App\Helpers\BaseHelper::limitChar(strip_tags($news[0]->text)) !!}</div>
                    </a>

                    {{-- <div class="viewLine">
                        <a href="{{ route('detalhe', ['title' => str_slug($news[0]->title), 'id' => $news[0]->id]) }}" class="viewNews">visualizar</a>

                        @if (count($news[0]->news) > 0)
                            <div class="othersVehicles">
                                <div class="title">outros veículos</div>
                                <div class="vehiclesLine">
                                    @foreach ($news[0]->news as $item)
                                        @if ($item->vehicle->id !== $vehicle->id)
                                            <a href="{{ route('detalhe', ['title' => str_slug($item->title), 'id' => $item->id]) }}" class="boxVehicle">{{ $item->vehicle->description }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div> --}}

                    <ul class="moreList">
                        @for ($i = 1; $i < count($news); $i++)
                            <li>
                                <a href="{{ route('detalhe', ['title' => str_slug($news[$i]->title), 'id' => $news[$i]->id]) }}">
                                    <h4>{{ $news[$i]->title }}</h4>
                                </a>

                                <div class="datePublic">
                                    Publicado em {{ $news[$i]->dt_publication->formatLocalized('%d %B %Y') }}
                                    {{-- @if (count($news[$i]->source) == 2)
                                        | <a href="{{ $news[0]->url_fapesp }}" class="text-{{ $news[0]->source['class'] }}">{{ $news[0]->source['name'] }}</a>
                                    @endif --}}
                                </div>

                                <a href="{{ route('detalhe', ['title' => str_slug($news[$i]->title), 'id' => $news[$i]->id]) }}">
                                    <div class="description">{!! $news[$i]->summary != '' ? strip_tags($news[$i]->summary) :  \App\Helpers\BaseHelper::limitChar(strip_tags($news[$i]->text)) !!}</div>
                                </a>

                                <a href="{{ route('detalhe', ['title' => str_slug($news[$i]->title), 'id' => $news[$i]->id]) }}" class="boxVehicle">ver notícia</a>
                            </li>
                        @endfor
                    </ul>
                @endif
            </div>

            @if ($lastPage > 1)
                <ul class="pagination" role="navigation">
                    @if ($lastPage > 5)
                        <li class="previous"><a href="{{ route('detalhe', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id, 'page' => ($currentPage - 1 > 0 ? $currentPage - 1 : 1)]) }}"><i class="fa fa-chevron-left"></i> Anterior</a></li>
                    @endif

                    @for ($i = 0; $i < count($rangePages); $i++)
                        @if ($currentPage !=  $rangePages[$i])
                            <li class="page-item">
                                <a class="page-link" href="{{ route('detalhe', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id, 'page' => $rangePages[$i]]) }}">
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
                        <li class="next"><a href="{{ route('detalhe', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id, 'page' => ($currentPage + 1 > $lastPage ? $lastPage : $currentPage + 1)]) }}">Próximo <i class="fa fa-chevron-right"></i></a></li>
                    @endif
                </ul>
            @endif
        </div>

        @include('site.includes.aside-home')
    </main>
@endsection