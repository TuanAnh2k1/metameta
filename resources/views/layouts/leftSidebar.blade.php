<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{route('home')}}">
            <span>DIAS</span>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{route('home')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-speedometer"></span><span class="mtext">{{__('app.dashboard')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('users.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-people"></span><span class="mtext">{{__('app.users')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('comments.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-card-text"></span><span class="mtext">{{__('app.comments')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('metameta.index')}}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-book"></span><span class="mtext">@lang('metameta.metameta')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>