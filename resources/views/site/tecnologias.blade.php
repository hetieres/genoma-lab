@include('layouts.includes.app-head')
<div class="container">
<Br><br>

<div>{!!html_entity_decode($DadosHead->text)!!} </div>

<div class="row">
    @foreach ($tecnologias as $item)
    <div class="col-md-12">
        <div class="single-recent">
            <div class="card mb-6 shadow-sm">
                <div class="card-body1 recent-articles-card3">
                    <p class="TextLimitedProjects" style="color: white; font-weight: 450; text-align: justify;">
                        {{ $item->title }}
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {!!html_entity_decode(str_replace("\n", "<br>", $item->summary))!!}
                    </p>
                    <center>
                        <button type="button" class="btn btn-primary" onclick="location.href = '{{  $item->link() }}';" >Leia Mais</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@include('layouts.includes.app-footer-site')