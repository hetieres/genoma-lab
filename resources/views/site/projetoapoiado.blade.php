@include('layouts.includes.app-head')
<Br><br>
<div class="container">
<h1 class="interal-title">{{ $DadosHead['title']  }}</h1>
<h2 class="sub-interal-title">{{ $DadosHead['summary'] }}</h2>
<div style="text-align: justify;">{!!html_entity_decode($DadosHead['text'])!!} </div>


<div class="row">
 
    <div class="col-md-12">
        <div class="single-recent">
            <div class="card mb-6 shadow-sm">
                <div class="card-body1 recent-articles-card3">
                    <p class="TextLimitedProjects" style="color: white; font-weight: 450; text-align: justify;">
                        {{ $tecnologias['title'] }}
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {!!html_entity_decode($tecnologias['text'])!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.includes.app-footer-site')