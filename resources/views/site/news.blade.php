@php($noSearch=false)
@extends('layouts.site')

@section('styles')
    <link href="{{ asset('assets/css/pages/news.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c489e80491ff5a2"></script>
@endsection

@section('content')
    <main class="container internal">
        <h1 class="noPrint">
            <span>Notícia</span>
            <ul class="breadcrumbs">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('vehicles') }}">Veículos</a></li>
                <li><a href="{{ route('detalhe', ['title' => str_slug($news->vehicle->description), 'id' => $news->vehicle->id]) }}">{{ $news->vehicle->description }}</a></li>
                @if (isset($news->source['url']) && $news->source['url'] != '')
                    <li class="active"><a href="{{$news->source['url']}}" target="_blank"><span>Notícia</span></a></li>
                @else
                    <li class="active"><span>Notícia</span></li>
                @endif
            </ul>
        </h1>

        <a href="{{ route('detalhe', ['title' => str_slug($news->vehicle->description), 'id' => $news->vehicle->id]) }}">
            <div class="boxVehicleBig">{{ $news->vehicle->description }}</div>
        </a>

        <section>
            @if (isset($news->source['url']) && $news->source['url'] != '')
                <h2> <a href="{{$news->source['url']}}" target="_blank">{!! $news->title !!}</a></h2>
            @else
                <h2>{!! $news->title !!}</h2>
            @endif
            <h3>
                Publicado em {{ $news->dt_publication->formatLocalized('%d %B %Y') }}
                {{-- @if(isset($news->source['class'])) | <a href="{{ $news->source['url'] }}" class="text-{{ $news->source['class'] }}" target="_blank"> {{ $news->source['name'] }} @endif</a> --}}
            </h3>
            <div class="addthis_inline_share_toolbox"></div>
            <article>
                @if ($news->author != '')
                    <div class="author">Por {!! $news->author !!}</div>
                @endif

                <div class="body">
                    @if (!$news->vehicle->limited_access)
                        {!! $news->text !!}
                    @else
                        {!! \App\Helpers\BaseHelper::limitChar(str_replace(["\n","\r","\t"], " ", strip_tags($news->text)), 550) !!}
                        <p></p><p></p><p>Conteúdo na íntegra disponível para assinantes do veículo.</p>
                    @endif
                </div>

                @if (
                    trim($news->url) != '' &&
                    $news->vehicle->media_type_id != 6 &&
                    $news->vehicle->media_type_id != 5
                    )
                    <div class="source">
                        <b>Fonte:</b> <a href="{{ $news->url }}" target="_blank">{{ $news->url }}</a>
                    </div>
                @endif

                @if (count($news->news) > 0)
                    <div class="viewLine clearfix noPrint">
                        <div class="title">Essa notícia também repercutiu nos veículos:</div>
                        @foreach ($news->news as $item)
                        <a href="{{ route('detalhe', ['title' => str_slug($item->title), 'id' => $item->id]) }}" class="boxVehicle">{{ $item->vehicle->description }}</a>
                        @endforeach
                    </div>
                @endif

                @if (isset($news->source['url']) && $news->source['url'] != '')
                    <div class="source">
                        <b>{{$news->source['site']}}:</b> <a href="{{ $news->source['url'] }}" target="_blank">{{ $news->source['url'] }}</a>
                    </div>
                @endif
            </article>
        </section>
    </main>
@endsection