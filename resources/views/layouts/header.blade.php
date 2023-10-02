@php
    use \Illuminate\Support\Facades\Auth;
    use \App\Core\Helper\CommonHelper;
@endphp
<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>
    </div>
    <div class="header-right">
        <div class="language-content">
            <a href="{{route('language','en')}}" class="language-text ">
                <span @if(!CommonHelper::isJalang()) class="text-primary" @endif >EN</span>
            </a>
            <a href="{{route('language', 'ja')}}" class="language-text">
                <span @if(CommonHelper::isJalang()) class="text-primary" @endif >JA</span>
            </a>
        </div>
        <div class="user-info-dropdown">
            <div class="dropdown">
                <div class="dropdown-toggle cursor-pointer" role="button" data-toggle="dropdown">
                    <span class="dropdown user-icon">
                        <img src="../../images/profile.svg" alt=""/>
                    </span>
                    <span class="user-name">{{Auth::user()->display_name ?? Auth::user()->username}}</span>
                </div>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <form id="logout-form" action="{{ route('cas.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="{{ route('cas.logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i> {{__('app.logout')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>