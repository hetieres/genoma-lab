@include('layouts.includes.app-head')
<Br><br>
<div class="container">
<div style="text-align: justify;">{!!html_entity_decode($DadosHead->text)!!} </div>

<div class="row">
    @foreach ($namidias as $item)
    <div class="col-md-12">
        <div class="single-recent">
            <div class="card mb-6 shadow-sm">
                <div class="card-body1 recent-articles-card3">
                    <p class="TextLimitedProjects" style="color: black; font-weight: 700; text-align: justify;">
                        {{ $item->title }}
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {!!html_entity_decode($item->dt_publication->format('d/m/Y'))!!}
                    </p>
                    <p class="card-text">
                        {!!html_entity_decode(str_replace("\n", "<br>", $item->summary))!!}
                    </p>
                </div>
                <center>
                    <button type="button" class="btn btn-primary" onclick="redirectPG('{{ $item->link() }}');">Leia Mais</button>
                </center>
                <br>
            </div>
        </div>
    </div>
    @endforeach
</div>
@include('layouts.includes.app-footer-site')