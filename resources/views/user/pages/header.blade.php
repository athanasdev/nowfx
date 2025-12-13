<header class="light-bb">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="/client/assets/img/logo-light.png"
                alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#headerMenu"
            aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="icon ion-md-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="headerMenu">
            <ul class="navbar-nav mr-auto">
                {{-- <a class="nav-link" href="{{ route('dashboard') }}">Trading view</a> --}}
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link " href="{{ route('market') }}" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                       Crypto's Markets
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('market') }}">Markets</a>
                        <a class="dropdown-item" href="{{ route('market-cap') }}">Market Capital</a>
                        <a class="dropdown-item" href="{{ route('market-bar') }}">Market Bar</a>
                    </div> 
                </li> --}}

                {{-- @auth
                    <a class="nav-link text-success fw-bold">
                        Credit(USDT): {{ Auth::user()->balance }}
                    </a>
                @endauth --}}



            </ul>
            <ul class="navbar-nav ml-auto">
                {{-- <li class="nav-item header-custom-icon">
                    <a class="nav-link" href="#" id="changeThemeLight">
                        <i class="icon ion-md-sunny"></i>
                    </a>
                </li> --}}
                {{-- <li class="nav-item header-custom-icon">
                    <a class="nav-link" href="#" id="clickFullscreen">
                        <i class="icon ion-md-expand"></i>
                    </a>
                </li> --}}

                @auth
                    <li class="nav-item dropdown header-custom-icon">
                        {{-- <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="icon ion-md-notifications"></i>
                            <span class="circle-pulse"></span>
                        </a> --}}
                        {{-- <div class="dropdown-menu">
                            <div class="dropdown-header d-flex align-items-center justify-content-between">
                                <p class="mb-0 font-weight-medium">6 New Notifications</p>
                                <a href="#!" class="text-muted">Clear all</a>
                            </div>
                            <div class="dropdown-body">
                                <a href="#!" class="dropdown-item">
                                    <div class="icon">
                                        <i class="icon ion-md-lock"></i>
                                    </div>
                                    <div class="content">
                                        <p>Account password change</p>
                                        <p class="sub-text text-muted">5 sec ago</p>
                                    </div>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <div class="icon">
                                        <i class="icon ion-md-alert"></i>
                                    </div>
                                    <div class="content">
                                        <p>Solve the security issue</p>
                                        <p class="sub-text text-muted">10 min ago</p>
                                    </div>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <div class="icon">
                                        <i class="icon ion-logo-android"></i>
                                    </div>
                                    <div class="content">
                                        <p>Download android app</p>
                                        <p class="sub-text text-muted">1 hrs ago</p>
                                    </div>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <div class="icon">
                                        <i class="icon ion-logo-bitcoin"></i>
                                    </div>
                                    <div class="content">
                                        <p>Bitcoin price is high now</p>
                                        <p class="sub-text text-muted">2 hrs ago</p>
                                    </div>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <div class="icon">
                                        <i class="icon ion-logo-usd"></i>
                                    </div>
                                    <div class="content">
                                        <p>Payment completed</p>
                                        <p class="sub-text text-muted">4 hrs ago</p>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <a href="#!">View all</a>
                            </div>
                        </div> --}}
                    </li>
                    <li class="nav-item dropdown header-img-icon">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="/client/assets/img/avatar.svg" alt="avatar">
                        </a>
                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    <img src="/client/assets/img/avatar.svg" alt="">
                                </div>

                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0">{{ Auth::user()->username ?? 'Guest' }}</p>
                                    <p class="email text-muted mb-3">{{ Auth::user()->email ?? '' }}</p>
                                </div>
                            </div>

                            <div class="dropdown-body">
                                <ul class="profile-nav">
                                    {{-- <li class="nav-item">
                                        <a href="{{ route('my-account') }}" class="nav-link">
                                            <i class="icon ion-md-person"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('my-wallet') }}" class="nav-link">
                                            <i class="icon ion-md-wallet"></i>
                                            <span>My Wallet</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('team') }}" class="nav-link">
                                            <i class="icon ion-md-person-add text-success"></i>
                                            <span>My Team</span>
                                        </a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="/withdraw/setup" class="nav-link">
                                            <i class="icon ion-md-settings"></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>

                                    {{-- ✅ Add this only if user is impersonating --}}
                                    @if (session()->has('impersonated_by'))
                                        <li class="nav-item">
                                            <a href="{{ route('impersonate.leave') }}" class="nav-link text-warning">
                                                <i class="icon ion-md-exit"></i>
                                                <span>Leave Impersonation</span>
                                            </a>
                                        </li>
                                    @endif

                                    <li class="nav-item">
                                        @auth
                                            <form method="POST" action="{{ route('user.logout') }}"
                                                class="logout-form-inline">
                                                @csrf
                                                <button type="submit" class="nav-link red"
                                                    style="background:none; border:none; cursor:pointer;">
                                                    <i class="icon ion-md-power"></i>
                                                    <span>Log Out</span>
                                                </button>
                                            </form>
                                        @endauth
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </li>
                @endauth


            </ul>
        </div>
    </nav>
</header>
