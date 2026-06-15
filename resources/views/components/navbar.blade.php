<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('listing.index') }}">
            <i class="bi bi-shop"></i> Marketplace
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listing.index') }}">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('message.list') }}">
                        <i class="bi bi-chat-dots"></i> Messages
                    </a>
                </li>
                @if(Auth::user()->isSeller())
                <li>
                    <a class="nav-link" href="{{ route('listing.myListings') }}">
                        <i class="bi bi-folder"></i> My Listings
                    </a>
                </li>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isSeller())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listing.create') }}">
                        <i class="bi bi-plus-circle"></i> Sell Item
                    </a>
                </li>
                @endif

                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Admin Panel
                    </a>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if(Auth::user()->isSeller() || Auth::user()->isAdmin())
                        <li><a class="dropdown-item" href="{{ route('listing.index') }}">My Dashboard</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @endif

                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.register') }}">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>