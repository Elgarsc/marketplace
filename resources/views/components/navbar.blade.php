<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('listing.index') }}">
            <i class="bi bi-shop"></i> {{ __('messages.global.app_name') }}
        </a>
        <div class="d-flex align-items-center">
            <a href="{{ route('lang.switch', 'lv') }}" class="btn btn-sm {{ App::getLocale() === 'lv' ? 'btn-primary' : 'btn-outline-primary' }} me-2">LV</a>
            <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm {{ App::getLocale() === 'en' ? 'btn-primary' : 'btn-outline-primary' }}">EN</a>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listing.index') }}">
                        <i class="bi bi-house-door"></i> {{ __('messages.nav.home') }}
                    </a>
                </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('message.list') }}">
                        <i class="bi bi-chat-dots"></i> {{ __('messages.nav.messages') }}
                    </a>
                </li>
                @if(Auth::user()->isSeller())
                <li>
                    <a class="nav-link" href="{{ route('listing.myListings') }}">
                        <i class="bi bi-folder"></i> {{ __('messages.nav.my_listings') }}
                    </a>
                </li>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isSeller())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listing.create') }}">
                        <i class="bi bi-plus-circle"></i> {{ __('messages.nav.sell_item') }}
                    </a>
                </li>
                @endif

                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> {{ __('messages.nav.admin_panel') }}
                    </a>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if(Auth::user()->isAdmin())
                        <li><a class="dropdown-item" href="{{ route('listing.index') }}">{{ __('messages.nav.my_dashboard') }}</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @endif

                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('messages.nav.logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> {{ __('messages.nav.login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.register') }}">
                        <i class="bi bi-person-plus"></i> {{ __('messages.nav.register') }}
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>