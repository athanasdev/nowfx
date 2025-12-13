<nav class="navbar navbar-expand fixed-bottom navbar-light bg-light border-top"
    style="z-index: 1100 !important; background-color:blue;">
    <div class="container-fluid">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('dashboard') }}">
                    <i class="icon ion-md-home" style="font-size: 20px;"></i>
                    <br>
                    <small>Home</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('my-wallet') }}">
                    <i class="icon ion-md-wallet" style="font-size: 20px;"></i>
                    <br>
                    <small>Assets</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('team') }}">
                    <i class="icon ion-md-person" style="font-size: 20px;"></i>
                    <br>
                    <small>Team</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('trading') }}" >
                    <i class="icon ion-md-trending-up" style="font-size: 20px;"></i>
                    <br>
                    <small>Trading</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('order') }}">
                    <i class="icon ion-md-list" style="font-size: 20px;"></i>
                    <br>
                    <small>Orders</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="{{ route('my-account') }}">
                    <i class="icon ion-md-person" style="font-size: 20px;"></i>
                    <br>
                    <small>Account</small>
                </a>
            </li>
        </ul>
    </div>
</nav>
