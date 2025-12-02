<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>9dfe</title>
    <link rel="icon" href="/client/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/client/assets/css/style.css">
    <script src="//code.jivosite.com/widget/lV3WFrkVOl" async></script>

</head>

<body id="dark">

    @include('user.pages.header');

    <div class="container-fluid mtb15 no-fluid">
        <div class="row sm-gutters">
            
            <div class="col-md-10 mx-auto">
                <div class="main-chart mb15 light-variant">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div id="tradingview_e8053"></div>
                        <script src="/client/assets/js/tv.js"></script>
                        <script>
                            new TradingView.widget({
                                "width": "100%",
                                "height": 550,
                                "symbol": "BITSTAMP:BTCUSD",
                                "interval": "D",
                                "timezone": "Etc/UTC",
                                "theme": "Light",
                                "style": "1",
                                "locale": "en",
                                "toolbar_bg": "#f1f3f6",
                                "enable_publishing": false,
                                "withdateranges": true,
                                "hide_side_toolbar": false,
                                "allow_symbol_change": true,
                                "show_popup_button": true,
                                "popup_width": "1000",
                                "popup_height": "650",
                                "container_id": "tradingview_e8053"
                            });
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="main-chart mb15 dark-variant">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div id="tradingview_e8033"></div>
                        <script src="/client/assets/js/tv.js"></script>
                        {{-- <script>
                            new TradingView.widget({
                                "width": "100%",
                                "height": 700,
                                "symbol": "BITSTAMP:BTCUSD",
                                "interval": "D",
                                "timezone": "Etc/UTC",
                                "theme": "dark",
                                "style": "1",
                                "locale": "en",
                                "toolbar_bg": "#f1f3f6",
                                "enable_publishing": false,
                                "withdateranges": true,
                                "hide_side_toolbar": false,
                                "allow_symbol_change": true,
                                "show_popup_button": true,
                                "popup_width": "1000",
                                "popup_height": "650",
                                "container_id": "tradingview_e8033"
                            });
                        </script> --}}

                        {{-- NEW UPDATE SCRIPTS FOR TRADING VIEW --}}
                         <script>
                            new TradingView.widget({
                                "width": "100%",
                                "height": 700,
                                "symbol": "BITSTAMP:ETHUSD",
                                "interval": "1H",
                                "timezone": "Etc/UTC",
                                "theme": "dark",
                                "style": "1",
                                "locale": "en",
                                "toolbar_bg": "#f1f3f6",
                                "enable_publishing": false,
                                "withdateranges": true,
                                "hide_side_toolbar": false,
                                "allow_symbol_change": true,
                                "show_popup_button": true,
                                "popup_width": "1000",
                                "popup_height": "650",
                                "container_id": "tradingview_e8033"
                            });
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>

                {{-- THE TRADING PANELS IS HERE  --}}

                <div class="market-trade">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#pills-trade-limit" role="tab"
                                aria-selected="true">Limit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#pills-market" role="tab"
                                aria-selected="false">Market</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#pills-stop-limit" role="tab"
                                aria-selected="false">Stop
                                Limit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#pills-stop-market" role="tab"
                                aria-selected="false">Stop
                                Market</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-trade-limit" role="tabpanel">
                           
                            <div class="d-flex justify-content-between">
                                {{-- BUY --}}
                                <div class="market-trade-buy" style="max-width: 48%">
                                    <form method="POST" action="{{ route('bot.place_trade') }}" id="buyForm">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <input type="number" name="amount" class="form-control" id="buyAmount"
                                                placeholder="Amount to buy" min="0" step="0.01" required />
                                            <input type="hidden" name="trade_type" value="buy" required>
                                            <select class="form-select" name="crypto_category" id="buyPair">
                                                <option value="BTC" selected>USDT/BTC</option>
                                                <option value="ETH">USDT/ETH</option>
                                                <option value="BNB">USDT/BNB</option>
                                                <option value="XRP">USDT/XRP</option>
                                                <option value="SOL">USDT/SOL</option>
                                                <option value="ADA">USDT/ADA</option>
                                                <option value="DOT">USDT/DOT</option>
                                                <option value="DOGE">USDT/DOGE</option>
                                                <option value="LTC">USDT/LTC</option>
                                            </select>
                                        </div>

                                        <ul class="market-trade-list" id="buyPercentages">
                                            <li><a href="#" data-percent="25">25%</a></li>
                                            <li><a href="#" data-percent="50">50%</a></li>
                                            <li><a href="#" data-percent="75">75%</a></li>
                                            <li><a href="#" data-percent="100">100%</a></li>
                                        </ul>

                                        <button type="submit" class="btn buy">Buy</button>
                                    </form>
                                </div>

                                {{-- SELL --}}
                                <div class="market-trade-sell" style="max-width: 48%">
                                    <form method="POST" action="{{ route('bot.place_trade') }}" id="sellForm">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <input type="number" name="amount" class="form-control"
                                                id="sellAmount" placeholder="Amount to sell" min="0"
                                                step="0.01" required />
                                            <input type="hidden" name="trade_type" value="sell" required>
                                            <select name="crypto_category" class="form-select" id="sellPair">
                                                <option value="BTC" selected>USDT/BTC</option>
                                                <option value="ETH">USDT/ETH</option>
                                                <option value="BNB">USDT/BNB</option>
                                                <option value="XRP">USDT/XRP</option>
                                                <option value="SOL">USDT/SOL</option>
                                                <option value="ADA">USDT/ADA</option>
                                                <option value="DOT">USDT/DOT</option>
                                                <option value="DOGE">USDT/DOGE</option>
                                                <option value="LTC">USDT/LTC</option>
                                            </select>

                                        </div>

                                        <ul class="market-trade-list" id="sellPercentages">
                                            <li><a href="#" data-percent="25">25%</a></li>
                                            <li><a href="#" data-percent="50">50%</a></li>
                                            <li><a href="#" data-percent="75">75%</a></li>
                                            <li><a href="#" data-percent="100">100%</a></li>
                                        </ul>

                                        <button type="submit" class="btn sell">Sell</button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                {{-- END OF TRADING ORDERS --}}

            </div>
            
        

            <div class="col-md-10 mx-auto">
                <div class="market-history market-order mt-3">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#open-orders" role="tab"
                                aria-selected="true">Open Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#order-history" role="tab"
                                aria-selected="false">Order History</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- OPEN ORDERS --}}
                        <div class="tab-pane fade show active" id="open-orders" role="tabpanel">
                            @if ($activeUserInvestment->isEmpty())
                                <div class="text-center text-muted p-3">
                                    <i class="icon ion-md-document"></i> No pending investments
                                </div>
                            @else
                                <div class="table-responsive" style="overflow-x:auto;">
                                    <table class="table table-striped mb-0 " style="min-width: 800px;">
                                        <thead class="">
                                            <tr>
                                                <th>Time</th>
                                                <th>Crypto</th>
                                                <th>Action</th>
                                                <th>Amount (USD)</th>
                                                <th>Daily Profit (USD)</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($activeUserInvestment as $inv)
                                                <tr>
                                                    <td>{{ $inv->created_at->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $inv->crypto_category ?? '-' }}</td>
                                                    <td
                                                        class="{{ $inv->type == 'sell' ? 'text-danger' : 'text-success' }}">
                                                        {{ $inv->type }}
                                                    </td>
                                                    <td>{{ number_format($inv->amount, 2) }}</td>
                                                    <td>{{ number_format($inv->daily_profit_amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-warning">{{ ucfirst($inv->investment_result) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($inv->investment_result === 'pending')
                                                            <form method="POST"
                                                                action="{{ route('bot.close_trade') }}"
                                                                onsubmit="return confirm('Are you sure you want to close this trade?');">
                                                                @csrf
                                                                <input type="hidden" name="user_investment_id"
                                                                    value="{{ $inv->id }}">
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-times-circle"></i> Close
                                                                </button>
                                                            </form>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        {{-- ORDER HISTORY --}}
                        <div class="tab-pane fade" id="order-history" role="tabpanel">
                            @if ($allUserInvestments->isEmpty())
                                <div class="text-center text-muted p-3">
                                    <i class="icon ion-md-document"></i> No investment history
                                </div>
                            @else
                                <div class="table-responsive" style="overflow-x:auto;">
                                    <table class="table table-striped mb-0 " style="min-width: 800px;">
                                        <thead class="">
                                            <tr>
                                                <th>Time</th>
                                                <th>Crypto</th>
                                                <th>Action</th>
                                                <th>Amount (USD)</th>
                                                <th>Daily Profit (USD)</th>
                                                <th>Total Paid (USD)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allUserInvestments as $inv)
                                                <tr>
                                                    <td>{{ $inv->created_at->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $inv->crypto_category ?? '-' }}</td>
                                                    <td
                                                        class="{{ $inv->type == 'sell' ? 'text-danger' : 'text-success' }}">
                                                        {{ $inv->type }}
                                                    </td>
                                                    <td>{{ number_format($inv->amount, 2) }}</td>
                                                    <td>{{ number_format($inv->daily_profit_amount, 2) }}</td>
                                                    <td>{{ number_format($inv->total_profit_paid_out, 2) }}</td>
                                                    <td>
                                                        @if ($inv->investment_result == 'gain')
                                                            <span class="badge badge-success">Gain</span>
                                                        @elseif ($inv->investment_result == 'lose')
                                                            <span class="badge badge-danger">Lose</span>
                                                        @elseif ($inv->investment_result == 'canceled')
                                                            <span class="badge badge-info">canceled</span>
                                                        @else
                                                            <span class="badge badge-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <script src="/client/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/client/assets/js/popper.min.js"></script>
    <script src="/client/assets/js/bootstrap.min.js"></script>
    <script src="/client/assets/js/amcharts-core.min.js"></script>
    <script src="/client/assets/js/amcharts.min.js"></script>
    <script src="/client/assets/js/jquery.mCustomScrollbar.js"></script>
    <script src="/client/assets/js/custom.js"></script>



    <script>
        $('tbody, .market-news ul').mCustomScrollbar({
            theme: 'minimal',
        });
    </script>

    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute(
            'content');
    </script>

    <!-- Include SweetAlert2 for toast notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const userBalance = {{ $user->balance }}; // Authenticated user balance from controller

            function setupPercentButtons(formId, amountInputId, percentageListId) {
                const form = document.getElementById(formId);
                const amountInput = document.getElementById(amountInputId);
                const percentageLinks = document.querySelectorAll(`#${percentageListId} a`);

                // Percentage buttons click
                percentageLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const percent = parseFloat(this.dataset.percent);
                        const calculatedAmount = (userBalance * percent / 100).toFixed(2);
                        amountInput.value = calculatedAmount;
                    });
                });

                // AJAX form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);

                    axios.post(form.action, formData)
                        .then(res => {
                            Swal.fire({
                                icon: res.data.success ? 'success' : 'error',
                                title: res.data.message || 'Trade placed!',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            // Optionally reset the input after success
                            if (res.data.success) {
                                amountInput.value = '';
                            }
                        })
                        .catch(err => {
                            let message = 'An error occurred';
                            if (err.response && err.response.data && err.response.data.errors) {
                                message = Object.values(err.response.data.errors).flat().join(', ');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: message,
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                });
            }

            // Setup Buy and Sell forms
            setupPercentButtons('buyForm', 'buyAmount', 'buyPercentages');
            setupPercentButtons('sellForm', 'sellAmount', 'sellPercentages');

        });
    </script>

<script>
// Disable right click
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();
});

// Disable keyboard shortcuts for copy, paste, view-source, inspect
document.addEventListener("keydown", function(e) {
    // Prevent Ctrl+U (view source), Ctrl+C (copy), Ctrl+V (paste), Ctrl+Shift+I (dev tools), F12
    if (
        (e.ctrlKey && (e.key === "u" || e.key === "U" || e.key === "c" || e.key === "v" || e.key === "x" || e.key === "s")) ||
        (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "i" || e.key === "J" || e.key === "j")) ||
        (e.key === "F12")
    ) {
        e.preventDefault();
    }
});

// Disable text selection
document.addEventListener("selectstart", function(e) {
    e.preventDefault();
});

// Disable drag
document.addEventListener("dragstart", function(e) {
    e.preventDefault();
});
</script>

<!-- Bottom Navigation Bar -->
<nav class="navbar navbar-expand fixed-bottom navbar-light bg-light border-top" style="z-index: 1030;">
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
                <a class="nav-link text-center" href="{{ route('ai-trading') }}">
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

</body>

</html>
