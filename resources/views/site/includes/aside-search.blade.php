<aside class="col-12 col-sm-4 col-md-3 no-padding-right no-padding-xs">
    <hr class="visible-xs" />
    <div class="box search">
        <h4><b>Filtros</b> da Pesquisa</h4>
        <ul>
            <li class="title bg-red">Período</li>
            <li class="period">
                <input type="text" name="daterange" value="{{ $period }}" readonly="true" />
                <button type="button"><i class="fa fa-search"></i></button>
            </li>
            <li class="title bg-red">Mídias</li>

            @foreach ($medias as $media)
                <li><a href="{{ $media->id }}" class="media {{ $media->class }}">{{ $media->description }} <span>({{ number_format($media->total, 0, ',', '.') }})</span></a></li>
            @endforeach
            
            @if (false)
                <li class="title bg-red-dark">Áreas de Conhecimento</li>
                <li>
                    <ul>
                        @foreach ($tags as $type)
                            <li class="btn-collapse">
                                <a href="javascript:;" class="btn btn-link" data-toggle="collapse" data-target="#{{ str_slug($type->type) }}" aria-controls="{{ str_slug($type->type) }}">{{ $type->type }} </a>
                            </li>
                            <li id="{{ str_slug($type->type) }}" class="{{ $type->class }}">
                                <ul>
                                    @foreach ($type->tags as $tag)
                                        <li><a href="{{ $tag->id }}" class="tag itemClass {{ $tag->class }}">{{ $tag->description }} <span>({{ $tag->newsTags->count() }})</span></a></li>
                                    @endforeach
                                    <li><a href="javascript:;" class="allArea">visualizar todas as tags <span>({{ $type->total }})</span></a></li>
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
         
            {{-- <li class="title  bg-red-dark">Origem da notícia</li>
            @foreach ($categories as $category)
                <li><a href="{{ $category->id }}" class="category {{ $category->class }}">{{ $category->description }} <span>({{ number_format($category->total, 0, ',', '.') }})</span></a></li>
            @endforeach --}}
           
            <li class="title bg-red">Ano de Publicação</li>
            @foreach ($years as $year)
                <li><a href="{{ $year->year }}" class="year {{ $year->class }}">{{ $year->year }} <span>({{ number_format($year->total, 0, ',', '.') }})</span></a></li>
            @endforeach
           
        </ul>
    </div>
</aside>