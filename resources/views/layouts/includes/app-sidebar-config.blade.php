<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-pencil"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-files-o"></i></a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Atividades Recentes</h3>
            <ul class="control-sidebar-menu">
                @foreach ($side_edit as $post)
                    <li>
                        <a href="{{ route('post-edit', ['id' => $post->id]) }}">
                            <i class="menu-icon fa fa-file-o bg-blue-active"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">{{ $post->title }}</h4>
                                <p>{{ isset($post->user->name) ? (explode(' ', $post->user->name))[0]  : '' }}  - {{ $post->created_at->format('d/m/Y') }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="tab-pane" id="control-sidebar-settings-tab">
            <h3 class="control-sidebar-heading">Últimas Matérias</h3>
            <ul class="control-sidebar-menu">
                @foreach ($side_news as $post)
                    <li>
                        <a href="{{ route('post-edit', ['id' => $post->id]) }}">
                            <i class="menu-icon fa fa-file-o bg-blue-active"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">{{ $post->title }}</h4>
                                <p>{{ isset($post->user->name) ? (explode(' ', $post->user->name))[0]  : '' }}  - {{ $post->created_at->format('d/m/Y') }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>