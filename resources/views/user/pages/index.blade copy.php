<!DOCTYPE html>
<html lang="en">


<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cex77</title>
    <link rel="icon" href="/client/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/client/assets/css/style.css">


</head>

<body id="dark">

    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>

    @include('user.pages.header');

    <div class="container-fluid mtb15 no-fluid">
        <div class="row sm-gutters">

            <div class="col-md-10 mx-auto">
                <!-- Dashboard Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center dashboard-card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="icon ion-md-wallet"></i> Account Balance</h5>
                                <p class="card-text text-success">{{ number_format($user->balance ?? 0, 2) }} USDT</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center dashboard-card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="icon ion-md-trending-up"></i> Lifetime P&L</h5>
                                <p class="card-text {{ $lifetime_pnl >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($lifetime_pnl, 2) }} USDT</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center dashboard-card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="icon ion-md-cash"></i> Total Withdrawals</h5>
                                <p class="card-text text-info">{{ number_format($totalWithdraws, 2) }} USDT</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card text-center dashboard-card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="icon ion-md-business"></i> Invested Capital</h5>
                                <p class="card-text text-primary">{{ number_format($investedCapital, 2) }} USDT</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center dashboard-card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="icon ion-md-people"></i> Referral Earnings</h5>
                                <p class="card-text text-warning">{{ number_format($totalReferralEarning, 2) }} USDT</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Details Section -->
                <div class="card mb-4 dashboard-card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="icon ion-md-person"></i> User Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="icon ion-md-contact text-primary"></i> <strong>Username:</strong> {{ Auth::user()->username ?? 'Guest' }}</p>
                                <p><i class="icon ion-md-fingerprint text-primary"></i> <strong>User ID:</strong> {{ Auth::user()->unique_id ?? 'NULL' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="icon ion-md-mail text-primary"></i> <strong>Email:</strong> {{ Auth::user()->email ?? 'no-email' }}</p>
                                <p><i class="icon ion-md-checkmark-circle {{ Auth::user()->status == 'active' ? 'text-success' : 'text-warning' }}"></i> <strong>Status:</strong> {{ Auth::user()->status ?? 'blocked' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Transactions</h5>
                            </div>
                            <div class="card-body">
                                @forelse($transactions as $transaction)
                                    <div class="mb-2">
                                        <small>{{ $transaction->created_at->format('d-m-Y') }} - {{ number_format($transaction->amount, 2) }} USDT</small>
                                        <br>
                                        <small class="text-muted">{{ $transaction->description }}</small>
                                    </div>
                                @empty
                                    <small class="text-muted">No recent transactions</small>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Withdrawals</h5>
                            </div>
                            <div class="card-body">
                                @forelse($withdrawals as $withdrawal)
                                    <div class="mb-2">
                                        <small>{{ $withdrawal->created_at ? $withdrawal->created_at->format('d-m-Y') : '-' }} - {{ number_format($withdrawal->amount, 2) }} USDT</small>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($withdrawal->status) }}</small>
                                    </div>
                                @empty
                                    <small class="text-muted">No recent withdrawals</small>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Deposits</h5>
                            </div>
                            <div class="card-body">
                                @forelse($deposits as $deposit)
                                    <div class="mb-2">
                                        <small>{{ $deposit->created_at ? $deposit->created_at->format('d-m-Y') : '-' }} - {{ number_format($deposit->price_amount, 2) }} {{ strtoupper($deposit->price_currency) }}</small>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($deposit->payment_status) }}</small>
                                    </div>
                                @empty
                                    <small class="text-muted">No recent deposits</small>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                
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
        // Hide preloader when page is fully loaded
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        });

        // Disable right click
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        });

        // Disable keyboard shortcuts for copy, paste, view-source, inspect
        document.addEventListener("keydown", function(e) {
            // Prevent Ctrl+U (view source), Ctrl+C (copy), Ctrl+V (paste), Ctrl+Shift+I (dev tools), F12
            if (
                (e.ctrlKey && (e.key === "u" || e.key === "U" || e.key === "c" || e.key === "v" || e.key === "x" ||
                    e.key === "s")) ||
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

   

    @include('user.common.navbar')

</body>

</html>
