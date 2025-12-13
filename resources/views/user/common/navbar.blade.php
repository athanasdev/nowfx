<nav class="navbar navbar-expand fixed-bottom navbar-light bg-light border-top" style="z-index: 1060; background-color:blue;">
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
                <a class="nav-link text-center" href="{{ route('assets') }}">
                    <i class="icon ion-md-wallet" style="font-size: 20px;"></i>
                    <br>
                    <small>Assets</small>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-center" href="#" data-toggle="modal" data-target="#aiTradingModal">
                    <i class="icon ion-md-trending-up" style="font-size: 20px;"></i>
                    <br>
                    <small>AI Trading</small>
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
