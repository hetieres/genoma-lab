@include('layouts.includes.app-head')
<div class="container">
<Br><br>
<div style="text-align: justify;">{!!html_entity_decode($DadosHead->text)!!} </div>
<div class="row">
    @foreach ($videos as $video)
    <div class="col-md-4">
        <div class="single-recent">
            <div class="card mb-5 shadow-sm" style="cursor: pointer;">
                <div class="card-body" onclick="location.href = '{!! $video->link() !!}';">
                    <center>
                        <img class="ImgTube" src="https://img.youtube.com/vi/{{ $video->id_youtube }}/0.jpg" alt="">
                        <div class="wrapper">
                            <p class="TextLimited text-justify">
                                {{ $video->summary }}
                            </p>
                        </div>
                    </center>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@include('layouts.includes.app-footer-site')