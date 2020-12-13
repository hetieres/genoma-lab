@include('layouts.includes.app-head')
<Br><br>
<div class="container">
<div style="text-align: justify;">{!!html_entity_decode($DadosHead->text)!!} </div>

<div class="row">
    @foreach ($educacaodifusoes as $item)
    <div class="col-md-12">
        <div class="single-recent">
            <div class="card mb-6 shadow-sm">
                <div class="card-body1 recent-articles-card3 educacaodifusoes-card">
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
                  <button type="button" class="ButtonG" onclick="location.href = ('{{ $item->link() }}');"">Leia mais</button>
                </center>
                <br>
            </div>
        </div>
    </div>
    @endforeach
</div>

@include('layouts.includes.app-footer-site')