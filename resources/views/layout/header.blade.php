<!-- Header Start-->
<header class="top-header">
    <nav class="navbar navbar-expand-md navbar-light p-md-0 pr-md-0 px-sm-0">
        <div class="container-fluid mx-lg-1">
            <div class="logo">
                <a class="navbar-brand " href="{{ route('home.page') }}">
                    <img src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ Config::get('app.name') }}" class="img-fluid logo_res">
                </a>
            </div>
            <button class="navbar-toggler custom-overflow" type="button" data-toggle="collapse"
                data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false"
                aria-label="Toggle navigation">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <div class="collapse navbar-collapse main-navbar" id="navbarToggler">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 menus-content">
                    <li class="nav-item ">
                        <a class="nav-link @if (Route::is('home.page')) active @endif" aria-current="page"
                            href="{{ route('home.page') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Route::is('home.tour.detail')) active @endif"
                            href=" @if (Route::is('home.page')) #choose_your_tour @else {{ env('APP_URL') }}#choose_your_tour @endif">Tour
                            of Choice</a>
                    </li>
                    @if (Route::is('home.tour.detail'))
                        <li class="nav-item">
                            <a class="nav-link " href="#upcoming_tournament"> Upcoming Tournament </a>
                        </li>
                    @endif
                    @if (!Auth::check())
                        <li class="nav-item">
                            <a class="btn common-primary-btn-outline " href="{{ route('register') }}">Register</a>
                        </li>
                        <li class="nav-item nav-last-btn">
                            <a class="btn common-primary-btn" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        <li class="nav-item nav-last-btn">
                            <a class="btn common-primary-btn-outline" href="{{ route('dashboard') }}"> My Profile </a>
                        </li>
                        <li class="nav-item nav-last-btn">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn common-primary-btn">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
