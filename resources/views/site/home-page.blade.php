@php($date = '')
@foreach ($list as $item)
    @if ($date != $item->dt_publication)
        <hr>
        <h2> Publicações de {{ $item->dt_publication->formatLocalized('%d de %B de %Y') }} </h2>
        @php($date = $item->dt_publication)
    @endif

    <ul>
        <li>
            <a href="{{ route('details', ['title' => str_slug($item->news[0]->title), 'id' => $item->news[0]->id]) }}">
                <h3>{{ $item->news[0]->title }}</h3>
                <div class="description">
                    {!! \App\Helpers\BaseHelper::limitChar(str_replace(["\n","\r","\t"], " ", strip_tags($item->news[0]->text)), 280) !!}
                </div>
            </a>

            <div class="viewLine clearfix">
                {{-- @if ($item->source['url'] <> '#')
                    <a href="{{ $item->source['url'] }}" class="boxMedia {{ $item->source['class'] }}" target="_blank">{{ $item->source['name'] }}</a>
                @else
                    <span class="boxMedia {{ $item->source['class'] }}">{{ $item->source['name'] }}</span>
                @endif --}}

                @if (count($item->news) > 0)
                    {{-- <div class="title">noticiado em:</div> --}}
                    @for ($i = 0; $i < count($item->news) && $i < 5; $i++)
                        <a href="{{ route('details', ['title' => str_slug($item->news[$i]->title), 'id' => $item->news[$i]->id]) }}" class="boxVehicle">{{ $item->news[$i]->vehicle->description }}</a>
                    @endfor
                    @if (count($item->news) > 5)
                        <a href="javascript:;" class="boxVehicle viewMore collapsed" data-toggle="collapse" data-target="#reverbPrev_{{ $item->news[0]->id }}"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>
                        <div id="reverbPrev_{{ $item->news[0]->id }}" class="col-12 no-padding collapse">
                            @for ($i = 5; $i < count($item->news); $i++)
                                <a href="{{ route('details', ['title' => str_slug($item->news[$i]->title), 'id' => $item->news[$i]->id]) }}" class="boxVehicle">{{ $item->news[$i]->vehicle->description }}</a>
                            @endfor
                        </div>
                    @endif
                @endif
            </div>
            @if (count($item->olds) > 0)
                <div class="viewLine previous clearfix">
                    {{-- <div class="boxMedia">
                        Anteriormente
                    </div> --}}
                    <div class="title">Anteriores:</div>
                    @for ($i = 0; $i < count($item->olds) && $i < 5; $i++)
                        <a href="{{ route('details', ['title' => str_slug($item->olds[$i]->title), 'id' => $item->olds[$i]->id]) }}" class="boxVehicle">{{ $item->olds[$i]->vehicle->description }}</a>
                    @endfor
                    @if (count($item->olds) > 5)
                        <a href="javascript:;" class="boxVehicle viewMorePre collapsed" data-toggle="collapse" data-target="#reverbPrev_{{ $item->olds[0]->id }}"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>
                        <div id="reverbPrev_{{ $item->olds[0]->id }}" class="col-12 no-padding collapse">
                            @for ($i = 5; $i < count($item->olds); $i++)
                                <a href="{{ route('details', ['title' => str_slug($item->olds[$i]->title), 'id' => $item->olds[$i]->id]) }}" class="boxVehicle">{{ $item->olds[$i]->vehicle->description }}</a>
                            @endfor
                        </div>
                    @endif
                </div>
            @endif
        </li>
    </ul>
@endforeach