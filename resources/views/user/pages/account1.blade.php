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
    @include('user.pages.header');

    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    <div class="nav flex-column nav-pills settings-nav" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="settings-profile-tab" data-toggle="pill" href="#settings-profile"
                            role="tab" aria-controls="settings-profile" aria-selected="true"><i
                                class="icon ion-md-person"></i> Profile</a>
                        <a class="nav-link" id="deposit-history-tab" data-toggle="pill" href="#deposit-history"
                            role="tab" aria-controls="diposit-history" aria-selected="false">
                            <i class="icon ion-md-wallet"></i> Deposits
                        </a>
                        <a class="nav-link" id="withdraw-history-tab" data-toggle="pill" href="#withdraw-history"
                            role="tab" aria-controls="withdraw-history" aria-selected="false">
                            <i class="icon ion-md-wallet"></i> Withdraws
                        </a>
                        
                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="settings-profile" role="tabpanel"
                            aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">General Information</h5>
                                    <div class="settings-profile">
                                        <form action="#">
                                            <img src="/client/assets/img/avatar.svg" alt="avatar">
                                            <div class="form-row mt-4">

                                                <div class="col-md-6">
                                                    <label for="formFirst">Username</label>
                                                    <input id="formFirst" type="text" class="form-control"
                                                        placeholder="" readonly
                                                        value="{{ Auth::user()->username ?? 'Guest' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="formFirst">UserID</label>
                                                    <input id="formFirst" type="text" class="form-control"
                                                        placeholder="" readonly
                                                        value="{{ Auth::user()->unique_id ?? 'NULL' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="formLast">Email</label>
                                                    <input id="formLast" type="text" class="form-control"
                                                        placeholder="Email" required
                                                        value="{{ Auth::user()->email ?? 'no-email' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="emailAddress">status</label>
                                                    <input id="emailAddress" type="text" class="form-control"
                                                        value="{{ Auth::user()->status ?? 'blocked' }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="balance">Balance</label>
                                                    <div class="input-group">
                                                        <input id="balance" type="number" class="form-control"
                                                            value="{{ Auth::user()->balance ?? 0 }}" readonly>
                                                        <span class="input-group-text">USDT</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title pl-4">Latest Transactions </h5>
                                    <div class="wallet-history  table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($transactions as $index => $transaction)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                                        <td>
                                                            @if ($transaction->status === 'success')
                                                                <i
                                                                    class="icon ion-md-checkmark-circle-outline green"></i>
                                                            @elseif($transaction->status === 'pending')
                                                                <i class="icon ion-md-close-circle-outline red"></i>
                                                            @else
                                                                <i class="icon ion-md-time-outline text-warning"></i>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($transaction->amount, 8) }} USDT</td>
                                                        <td>{{ $transaction->description }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No transactions found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center mt-3 pagination-wrapper">
                                            {{ $transactions->links('vendor.pagination.custom') }}
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="tab-pane fade" id="withdraw-history" role="tabpanel"
                            aria-labelledby="withdraw-history-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title pl-4">Withdraw History</h5>
                                    <div class="wallet-history table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($withdrawals as $index => $withdrawal)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $withdrawal->created_at ? $withdrawal->created_at->format('d-m-Y') : '-' }}
                                                        </td>
                                                        <td>
                                                            @if ($withdrawal->status === 'complete')
                                                                <i class="icon ion-md-checkmark-circle-outline text-success"></i>
                                                            @elseif($withdrawal->status === 'pending')
                                                                <i class="icon ion-md-close-circle-outline text-warning"></i>
                                                            @else
                                                                <i class="icon ion-md-close-circle-outline text-danger"></i>
                                                            @endif
                                                            {{ ucfirst($withdrawal->status) }}
                                                        </td>
                                                        <td>{{ number_format($withdrawal->amount, 2) }} USDT</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No withdrawals found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center mt-3 pagination-wrapper">
                                            {{ $withdrawals->links('vendor.pagination.custom') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="tab-pane fade" id="deposit-history" role="tabpanel"
                            aria-labelledby="deposit-history-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title pl-4">Deposit History</h5>
                                    <div class="wallet-history table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($payments as $index => $payment)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $payment->created_at ? $payment->created_at->format('d-m-Y') : '-' }}
                                                        </td>
                                                        <td>
                                                            @if ($payment->payment_status === 'finished')
                                                                <i class="icon ion-md-checkmark-circle-outline text-success"></i>
                                                            @elseif($payment->payment_status === 'waiting')
                                                                <i class="icon ion-md-time text-warning"></i>
                                                            @elseif($payment->payment_status === 'failed')
                                                                <i
                                                                    class="icon ion-md-close-circle-outline text-danger"></i>
                                                            @else
                                                                <i
                                                                    class="icon ion-md-help-circle-outline text-secondary"></i>
                                                            @endif
                                                            {{ ucfirst($payment->payment_status) }}
                                                        </td>
                                                        <td>{{ number_format($payment->price_amount, 2) }}
                                                            {{ strtoupper($payment->price_currency) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No deposits found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center mt-3 pagination-wrapper">
                                            {{ $payments->links('vendor.pagination.custom') }}
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
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
    <script src="/client/assets/js/custom.js"></script>
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

@include('user.common.navbar')

</body>



</html>
