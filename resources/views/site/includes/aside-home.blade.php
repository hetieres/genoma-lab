<aside class="col-12 col-sm-4 col-md-3 no-padding-right no-padding-xs">
    <hr class="visible-xs" />

    <div class="box title">
        <h3><b>Destaques</b> em {{ $asideYear }}</h3>
    </div>

    <div class="box high">
        <h4><b>Mais </b>noticiadas no país</h4>
        <ul>
            @foreach ($more_viewed as $news)
                <li>
                    <a href="{{ route('detalhe', ['title' => str_slug($news->title), 'id' => $news->id]) }}">
                        {{-- <div class="title">{{ $news->title }}</div> --}}
                        <div class="description">{{ $news->title }} ({{ number_format($news->total, 0, ',', '.') }} notícias)</div>
                        {{-- <div class="vehicle">{{ $news->vehicle->description }}</div> --}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="box high2">
        <h4><b>Mais </b>noticiadas no mundo</h4>
        <ul>
            @foreach ($more_viewed_international as $news)
                <li>
                    <a href="{{ route('detalhe', ['title' => str_slug($news->title), 'id' => $news->id]) }}">
                        {{-- <div class="title">{{ $news->title }}</div> --}}
                        <div class="description">{{ $news->title }} ({{ number_format($news->total, 0, ',', '.') }} notícias)</div>
                        {{-- <div class="vehicle">{{ $news->vehicle->description }}</div> --}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="box vehicle">
        <h4><a href="{{ route('vehicles') }}"><b>Veículos </b> Nacionais</a></h4>
        <ul>
            @foreach ($asideVehicle as $vehicle)
                <li><a href="{{ route('detalhe', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id]) }}"> {{ $vehicle->description }} <span>({{ number_format($vehicle->total, 0, ',', '.') }} notícias)</span></a></li>
            @endforeach
        </ul>
    </div>

    <div class="box vehicleExternal">
        <h4><a href="{{ route('vehicles-int') }}"><b>Veículos</b> Internacionais</a></h4>
        <ul>
            @foreach ($asideVehicleExternal as $vehicle)
                <li><a href="{{ route('detalhe', ['title' => str_slug($vehicle->description), 'id' => $vehicle->id]) }}"> {{ $vehicle->description }} <span>({{ number_format($vehicle->total, 0, ',', '.') }} notícias)</span></a></li>
            @endforeach
        </ul>
    </div>

    @if(isset($asideCategories) && count($asideCategories) > 0 && false)
        <div class="box media">
            <h4><b>Origem da notícia</b></h4>
            <ul>
                @foreach ($asideCategories as $category)
                    <li><a href="{{ route('search') . '?c=' . $category->id }}"> {{ $category->description }} <span>({{ number_format($category->total, 0, ',', '.') }} notícias)</span></a></li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($asideTags))
        <div class="box tag">
            <h4><b>Áreas</b> de Conhecimento</h4>
            <ul>
                @foreach ($asideTags as $tag)
                <li><a href="{{ route('search') . '?t=' . $tag->ids }}"> {{ $tag->type }} <span>({{ number_format($tag->total, 0, ',', '.') }} notícias)</span></a></li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($asideCountries))
        <div class="box country">
            <h4><b>Notícias</b> por País</h4>
            <ul>
                @foreach ($asideCountries as $country)
                <li><a href="{{ route('country', ['description' => str_slug($country->description), 'id' => $country->id]) }}"> {{ $country->description }} <span>({{ number_format($country->total, 0, ',', '.') }} notícias)</span></a></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="box media">
        <h4><b>Plataformas</b></h4>
        <ul>
            @foreach ($asideMedias as $media)
                <li><a href="{{ route('search') . '?m=' . $media->id . '&y=' . $asideYear }}"> {{ $media->description }} <span>({{ number_format($media->total, 0, ',', '.') }} notícias)</span></a></li>
            @endforeach
        </ul>
    </div>

    @if (isset($asideYears))
        <div class="box year">
            <h3><b>Notícias</b> por ano</h3>
            <ul>
                @foreach ($asideYears as $year)
                <li><a href="{{ route('search') . '?y=' . $year->year }}"> {{ $year->year }} <span>({{ number_format($year->total, 0, ',', '.') }} notícias)</span></a></li>
                @endforeach
            </ul>
        </div>
    @endif
</aside>