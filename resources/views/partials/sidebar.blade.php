<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <h2 class="text-center text-light">OETS</h2>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ auth()->user()->name  }}</span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{ route('change-password') }}"><i
                                        class="fa fa-key"></i>{{ trans('sidebar.change_password')}}</a></li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                <i class="fa fa-sign-out"></i> {{ trans('sidebar.logout')}}
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    OETS
                </div>
            </li>

            @php
                $userRole = \App\Models\UserRole::where('user_id', auth()->user()->id)->get();

                $menuIds = \App\Models\RoleMenu::whereIn('role_id', [implode(",", array_column($userRole->toArray(), "role_id"))])->get();

                $menus = \App\Models\Menu::whereIn('id', array_column($menuIds->toArray(), "menu_id"))->get();

            @endphp

            @forelse($menus as $menu)
                <li class="active"><a href="{{ route($menu->route) }}"><i class="fa fa-th-large"></i>{{ trans('sidebar.'.$menu->slug)}}</a></li>
            @empty
            @endforelse

            {{--<li class="active"><a href="{{ route('users.index') }}"><i
                            class="fa fa-th-large"></i>{{ trans('sidebar.user_management')}}</a></li>
            <li class="active"><a href="{{ route('subjects.index') }}"><i
                            class="fa fa-book"></i>{{ trans('sidebar.subject')}}</a></li>
            <li class="active"><a href="{{ route('questions.index') }}"><i
                            class="fa fa-book"></i>{{ trans('sidebar.question')}}</a></li>
            <li class="active"><a href="{{ route('exams.index') }}"><i
                            class="fa fa-exchange"></i>{{ trans('sidebar.exam')}}</a></li>
            <li class="active"><a href="{{ route('question-papers.index') }}"><i
                            class="fa fa-file"></i>{{ trans('sidebar.exam_paper')}}</a></li>
            <li class="active"><a href="{{ route('question-assigns.index') }}"><i
                            class="fa fa-arrow-circle-o-right"></i>{{ trans('sidebar.question_assign')}}</a></li>
            <li class="active"><a href="{{ route('tests.index') }}"><i
                            class="fa fa-puzzle-piece"></i>{{ trans('sidebar.test')}}</a></li>--}}

        </ul>

    </div>
</nav>
