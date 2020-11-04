@include('layouts.includes.app-head')
<div class="container">
    <Br><br>
    <div style="text-align: justify;">{!!html_entity_decode($DadosHead->text)!!} </div>

    <center>
        <img class="img-fluid" src="{{ asset('/files/post/eventos-2020-14304-covid3.jpg') }}">
    </center>
    <br><br>

    <div class="row">
        @foreach ($webinars as $item)
        <div class="col-md-4">
            <div class="single-recent">
                <div class="card mb-5 shadow-sm">


                    <div class="card-body1 recent-articles-card4">
                        <p class="TextLimitedProjects" style="color: white; font-weight: 450;height: 90px;margin-bottom: 0px !important;">
                            {{ $item->title }}
                        </p>
                    </div>




                    <div class="card-body">
                        <p class="card-title">
                            {{-- {!!html_entity_decode($item->text)!!} --}}
                        </p>
                        <p class="card-text TextLimitedWebNars" style="height: 213px;margin-bottom: 0px !important;">
                            {!!html_entity_decode($item->summary)!!}
                        </p>
                        <center style="margin-top: 0px;">
                            <button type="button" class="btn btn-primary" onclick="redirectPG('{{ $item->link() }}');">Leia Mais</button>


                            @if($item->live != "null" && $item->live != "")
                            <br><br>
                            <input type="button" class="btn3 btn btn-danger btn-sm" onclick="redirectPG('{{ $item->live }}');" value="Live">

                            @elseif($item->id_youtube != "null" && $item->id_youtube != "")
                            @php
                            $urlVideo = "https://www.youtube.com/watch?v=".$item->id_youtube
                            @endphp

                            <br><br>
                            <input type="button" class="btn4 btn btn-success btn-sm" onclick="redirectPG('{{ $urlVideo }}');" value="Vídeo">

                            @else
                            <br><br><br>
                            @endif


                        </center>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @include('layouts.includes.app-footer-site')