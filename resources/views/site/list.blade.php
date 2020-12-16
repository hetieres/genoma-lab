@include('layouts.includes.app-head')
<Br><br>
<div class="container">
<h1 class="interal-title" style="padding-top: 0px; color: {{ $session->color }};">{{ $session->description }}</h1>

<div class="row">
    @foreach ($session->posts as $item)
    <div class="col-md-12">
        <div class="single-recent">
            <div class="card mb-6 shadow-sm">
                <div class="card-body1 recent-articles-card3 " style="background-color: {{ $session->color }};">
                    <p class="TextLimitedProjects" style="color: white; text-align: justify;">
                        {{ $item->title }}
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {!! str_replace("\n", "<br>", str_replace("\n", "<br>", $item->summary)) !!}
                    </p>
                </div>
                <center>
                  <button type="button" class="ButtonG" onclick="location.href = ('{{ $item->link() }}');">Leia mais</button>
                </center>
                <br>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-md-12">
    <ul class="pagination" role="navigation">
        @if ($lastPage > 5)
            <li class="previous"><a href="{{ route('detalhe', ['slug' => $slug, 'id' => ($currentPage - 1 > 0 ? $currentPage - 1 : 1) ]) }}"><i class="fa fa-chevron-left"></i> Anterior</a></li>
        @endif
        @for ($i = 0; $i < count($rangePages); $i++)
            @if ($currentPage !==  $rangePages[$i])
                <li class="page-item">
                    <a class="page-link" href="{{ route('detalhe', ['slug' => $slug, 'id' => $rangePages[$i] ]) }}">
                        {{ $rangePages[$i] }}
                    </a>
                </li>
            @else
                <li class="page-item" >
                    <a class="page-link" href="#" style="background-color: {{  $session->color }}; color: white;">
                        {{ $rangePages[$i] }}
                    </a>
                </li>
            @endif
        @endfor
        @if ($lastPage > 5)
            <li class="next"><a href="{{ route('detalhe', ['slug' => $slug, 'id' => ($currentPage + 1 > $lastPage ? $lastPage : $currentPage + 1) ])  }}">Próximo <i class="fa fa-chevron-right"></i></a></li>
        @endif
    </ul>
    </div>
</div>
@include('layouts.includes.app-footer-site')