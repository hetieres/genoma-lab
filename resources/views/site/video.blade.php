@include('layouts.includes.app-head')
<div class="container">
<Br><br>
<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<div class="addthis_inline_share_toolbox" style="padding-bottom:10px;"></div>
<h1 class="interal-title">{{$DadosHead->title}}</h1>

<div class="row">
    <div class="col-md-12">
        <div class="videoWrapper">
            <!-- Copy & Pasted from YouTube -->
            <iframe width="560" height="349" src="http://www.youtube.com/embed/{{ $post->id_youtube }}" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
@include('layouts.includes.app-footer-site')