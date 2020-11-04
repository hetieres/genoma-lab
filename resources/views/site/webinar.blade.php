@include('layouts.includes.app-head')
<div class="container">
<Br><br>
<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<div class="addthis_inline_share_toolbox" style="padding-bottom:10px;"></div>
<h1 class="interal-title">{{$DadosHead->title}}</h1>

<div class="row">
    <div class="col-md-12">
        <div class="single-recent">
            <div class="card mb-6 shadow-sm">
                <div class="card-body1 recent-articles-card4">
                    <p class="TextLimitedProjects" style="color: white; font-weight: 450; text-align: justify;">
                        {{ $post->title }}
                    </p>
                </div>
                <div class="card-body text-justify">
                {{-- <p class="card-title">
                         {!!html_entity_decode($post->summary)!!} 
                    </p> --}}
                    <p class="card-text responsive-iframe">
                        {!!html_entity_decode($post->text)!!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.includes.app-footer-site')