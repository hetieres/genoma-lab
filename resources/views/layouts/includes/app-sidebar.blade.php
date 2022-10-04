<section class="sidebar">
    {{-- <div class="user-panel">
        @if (true)
            <div class="pull-left image">
            <img src="{{ $photo }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
            </div>
        @endif
    </div> --}}
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU </li>
        <li @if(Route::current()->getName()=='post-list'.$routelang) class="active" @endif>
            <a href="{{ route('post-list'.$routelang) }}">
                <i class="fa fa-files-o"></i> <span>{{ $lang=="pt" ? "Matérias" : "Posts" }} </span>
            </a>
        </li>

        <li @if(Route::current()->getName()=='post-new'.$routelang) class="active" @endif>
            <a href="{{ route('post-new'.$routelang) }}">
                <i class="fa fa-file-o"></i> <span>{{ $lang=="pt" ? "Nova Matéria" : "New Post" }} </span>
            </a>
        </li>

        <li @if(Route::current()->getName()=='post-order'.$routelang) class="active" @endif>
            <a href="{{ route('post-order'.$routelang) }}">
                <i class="fa fa-arrows-v"></i> <span>{{ $lang=="pt" ? "Destaques" : "Highlights" }} </span>
            </a>
        </li>

        <li  @if(isset($post) && $post->id == 19) class="active" @endif>
            <a href="{{ route('post-edit'.$routelang, ['id' => ($lang=='pt'?19:99)]) }}">
                <i class="fa fa-pencil"></i> <span>Menu Home </span>
            </a>
        </li>

        <li @if(Route::current()->getName()=='import-test'.$routelang) class="active" @endif>
            <a href="{{ route('import-test'.$routelang) }}">
                <i class="fa fa-table"></i> <span>{{ $lang=="pt" ? "Testes Genéticos" : "Genetic Tests" }} </span>
            </a>
        </li>


        {{--

        <li>
            <a href="{{ route('post-list'.($lang=='pt' ? '-en' : '')) }}">
                <i class="fa fa-language"></i> <span> {{ $lang=='en' ? 'Português' : 'English'}} </span>
            </a>
        </li>

        <li class="header">{{ $lang=='pt' ? ' SEÇÕES' : 'SESSIONS' }}</li>
            @foreach ($sessions_edit as $item)
                <li @if(Route::current()->getName()=='session-edit'.$routelang && isset($session) && $session->id == $item->id) class="active" @endif>
                    <a href="{{route('session-edit'.$routelang, ['id' => $item->id]) }}">
                        <i class="fa fa-object-group"></i> <span>{{$item->description}} </span>
                    </a>
                </li>
            @endforeach
        <li class="header">RELATÓRIOS</li>
        @if(Auth::user()->type !== 'clipping')
        <li @if(Route::current()->getName()=='report-general'.$routelang) class="active" @endif>
            <a href="{{ route('report-general') }}">
                <i class="fa fa-fw fa-th"></i> <span>Relatórios</span>
            </a>
        </li>
        <li @if(Route::current()->getName()=='report-team'.$routelang) class="active" @endif>
            <a href="{{ route('report-team') }}">
                <i class="fa fa-users"></i> <span>Equipe</span>
            </a>
        </li>
        @endif
        <li @if(Route::current()->getName()=='links-report'.$routelang) class="active" @endif>
            <a href="{{ route('links-report') }}">
                <i class="fa fa-fw fa-link"></i> <span>URL's  </span>
            </a>
        </li> --}}

        @if(Auth::user()->type==='admin')
            <li class="header">GERENCIAMENTO</li>
            <li @if(Route::current()->getName()=='users'.$routelang) class="active" @endif>
                <a href="{{ route('users'.$routelang) }}">
                    <i class="fa fa-users"></i> <span>Usuários</span>
                </a>
            </li>
        @endif

        {{-- <li class="header">LABELS</li>
        <li>
            <a href="#">
                <i class="fa fa-circle-o text-red"></i> <span>Falta Implementar</span>
                <span class="pull-right-container"><small class="label pull-right bg-red">soon</small></span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-circle-o text-yellow"></i> <span>Em Desenvolvimento</span>
                <span class="pull-right-container"><small class="label pull-right bg-yellow">dev</small></span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-circle-o text-aqua"></i> <span>Ajustes Pendentes</span>
                <span class="pull-right-container"><small class="label pull-right bg-aqua">adjusts</small></span>
            </a>
        </li> --}}
    </ul>
</section>