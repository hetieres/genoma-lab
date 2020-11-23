@include('layouts.includes.app-head')
<Br><br>

<div class="container">
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <div class="addthis_inline_share_toolbox" style="padding-bottom:10px;"></div>
    <h1 class="interal-title">{{$DadosHead->title}}</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="single-recent">
                <div class="card mb-6 shadow-sm">
                    <div class="card-body1 recent-articles-card3 recent-articles-card3-Pesquisa">
                        <p class="TextLimitedProjects" style="color: black; font-weight: 700; text-align: justify;">
                            {{ $post->title }}
                        </p>
                    </div>
                    <div class="card-body">
                        <div >
                            {!!html_entity_decode($post->text)!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.includes.app-footer-site')