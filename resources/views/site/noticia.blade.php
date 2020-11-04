@include('layouts.includes.app-head')
<Br><br>
<div class="container">
    <div class="addthis_inline_share_toolbox" style="padding-bottom:10px;"></div>
    <h1 class="interal-title">{{$DadosHead->title}}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-6 shadow-sm">
                <p class="card-body1 recent-articles-card3" style="color: white; font-weight: 450; text-align: justify;">{{ $post->title }}</p>
                <div class="card-body">
                    <p class="card-text">
                        <div class="imgTextLeft">
                            <img src="{{ asset($post->image) }}" class="img-fluid">
                            <em>
                                <p style="margin-top: 10px;text-align: right;font-size: 15px;">{{$post->caption_image}}</p>
                            </em>
                        </div>

                        <div class="card-text">
                            <em>{{ $post->dt_publication->format('d/m/Y') }}
                                <br>
                                <br>
                                {!!html_entity_decode(str_replace("\n", "<br>", $post->summary))!!}</em>
                            <br><br>
                            {!!html_entity_decode($post->text)!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.includes.app-footer-site')