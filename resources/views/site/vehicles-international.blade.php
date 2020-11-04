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
            <span>Veículos Internacionais</span>
            <ul class="breadcrumbs">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active"><span>Veículos Internacionais</span></li>
            </ul>
        </h1>

        <div class="col-12 col-sm-8 col-md-9 no-padding-left no-padding-xs">
            <ul class="vehiclesList">
                @foreach ($vehicles as $vehicle)
                    <li>
                        <a href="{{ route('details', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id]) }}">
                            <div class="boxVehicleBig">{{ $vehicle->description }}</div>
                        </a>
                        <h3>{{ $vehicle->total }} notícias</h3>
                        <div class="lastPublic">Última publicação referente a FAPESP realizada em {{ $vehicle->lastNews->dt_publication->formatLocalized('%d %B %Y') }}</div>
                        <a href="{{ route('details', ['title' => str_slug($vehicle->lastNews->title), 'id' => $vehicle->lastNews->id]) }}">
                            <h4>{{ $vehicle->lastNews->title }}</h4>
                            <div class="description">
                                {!! $vehicle->lastNews->summary != '' ? strip_tags($vehicle->lastNews->summary) :  \App\Helpers\BaseHelper::limitChar(strip_tags($vehicle->lastNews->text))  !!}
                            </div>
                        </a>
                        <a href="{{ route('details', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id]) }}" class="viewNews">ver notícias</a>
                    </li>
                @endforeach
            </ul>

            <ul class="pagination" role="navigation">
                @if ($lastPage > 5)
                    <li class="previous"><a href="{{ route('details', ['page' => ($currentPage - 1 > 0 ? $currentPage - 1 : 1), 'title' => $vehicle->description, 'id' => $vehicle->id]) }}"><i class="fa fa-chevron-left"></i> Anterior</a></li>
                @endif

                @for ($i = 0; $i < count($rangePages); $i++)
                    @if ($currentPage !==  $rangePages[$i])
                        <li class="page-item">
                            <a class="page-link" href="{{ route('details', ['page' => $rangePages[$i], 'title' => $vehicle->description, 'id' => $vehicle->id]) }}">
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
                    <li class="next"><a href="{{ route('details', ['page' => ($currentPage + 1 > $lastPage ? $lastPage : $currentPage + 1), 'title' => $vehicle->description, 'id' => $vehicle->id]) }}">Próximo <i class="fa fa-chevron-right"></i></a></li>
                @endif
            </ul>

        </div>

        @include('site.includes.aside-home')
    </main>
@endsection