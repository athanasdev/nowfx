<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cex77 - Account</title>
    <link rel="icon" href="/client/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/client/assets/css/style.css">
</head>

<body id="dark">
    @include('user.pages.header')

    <div class="container-fluid mtb15">
        <div class="row">
            <!-- Simple Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Account Menu</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#profile" class="list-group-item list-group-item-action active" data-toggle="tab">
                            <i class="icon ion-md-person mr-2"></i> Profile
                        </a>
                        <a href="#withdrawals" class="list-group-item list-group-item-action" data-toggle="tab">
                            <i class="icon ion-md-arrow-up mr-2"></i> Withdrawals
                            @if($withdrawals->count() > 0)
                            <span class="badge badge-secondary float-right">{{ $withdrawals->count() }}</span>
                            @endif
                        </a>
                        <a href="#deposits" class="list-group-item list-group-item-action" data-toggle="tab">
                            <i class="icon ion-md-arrow-down mr-2"></i> Deposits
                            @if($payments->count() > 0)
                            <span class="badge badge-secondary float-right">{{ $payments->count() }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">User Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center mb-4">
                                        <img src="/client/assets/img/avatar.svg" alt="Avatar" class="img-fluid rounded-circle mb-3" style="max-width: 120px;">
                                        <h5>{{ Auth::user()->username ?? 'Guest' }}</h5>
                                        <span class="badge {{ Auth::user()->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst(Auth::user()->status ?? 'blocked') }}
                                        </span>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 30%">User ID</th>
                                                        <td>{{ Auth::user()->unique_id ?? 'NULL' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td>{{ Auth::user()->email ?? 'no-email' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Balance</th>
                                                        <td class="font-weight-bold">{{ number_format(Auth::user()->balance ?? 0, 2) }} USDT</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Member Since</th>
                                                        <td>{{ Auth::user()->created_at ? Auth::user()->created_at->format('F d, Y') : 'Unknown' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Recent Transactions</h5>
                            </div>
                            <div class="card-body">
                                @if($transactions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                                <td>{{ $transaction->description }}</td>
                                                <td class="font-weight-bold">{{ number_format($transaction->amount, 8) }} USDT</td>
                                                <td>
                                                    @if ($transaction->status === 'success')
                                                    <span class="badge badge-success">Success</span>
                                                    @elseif($transaction->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                    @else
                                                    <span class="badge badge-danger">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $transactions->links('vendor.pagination.custom') }}
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <p class="text-muted mb-0">No transactions found</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawals Tab -->
                    <div class="tab-pane fade" id="withdrawals">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Withdrawal History</h5>
                                <a href="{{ route('withdraw') }}" class="btn btn-primary btn-sm">
                                    <i class="icon ion-md-add mr-1"></i> New Withdrawal
                                </a>
                            </div>
                            <div class="card-body">
                                @if($withdrawals->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($withdrawals as $withdrawal)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $withdrawal->created_at ? $withdrawal->created_at->format('d/m/Y H:i') : '-' }}</td>
                                                <td class="font-weight-bold">{{ number_format($withdrawal->amount, 2) }} USDT</td>
                                                <td>
                                                    @if ($withdrawal->status === 'complete')
                                                    <span class="badge badge-success">Completed</span>
                                                    @elseif($withdrawal->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                    @else
                                                    <span class="badge badge-danger">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $withdrawals->links('vendor.pagination.custom') }}
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <p class="text-muted mb-3">No withdrawals found</p>
                                    <a href="{{ route('withdraw') }}" class="btn btn-primary">
                                        Make Your First Withdrawal
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Deposits Tab -->
                    <div class="tab-pane fade" id="deposits">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Deposit History</h5>
                                <a href="{{ route('deposit.form') }}" class="btn btn-primary btn-sm">
                                    <i class="icon ion-md-add mr-1"></i> New Deposit
                                </a>
                            </div>
                            <div class="card-body">
                                @if($payments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->created_at ? $payment->created_at->format('d/m/Y H:i') : '-' }}</td>
                                                <td class="font-weight-bold">{{ number_format($payment->price_amount, 2) }} {{ strtoupper($payment->price_currency) }}</td>
                                                <td>
                                                    @if ($payment->payment_status === 'finished')
                                                    <span class="badge badge-success">Completed</span>
                                                    @elseif($payment->payment_status === 'waiting')
                                                    <span class="badge badge-warning">Pending</span>
                                                    @elseif($payment->payment_status === 'failed')
                                                    <span class="badge badge-danger">Failed</span>
                                                    @else
                                                    <span class="badge badge-secondary">Unknown</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $payments->links('vendor.pagination.custom') }}
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <p class="text-muted mb-3">No deposits found</p>
                                    <a href="{{ route('deposit.form') }}" class="btn btn-primary">
                                        Make Your First Deposit
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.common.navbar')

    <script src="/client/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/client/assets/js/popper.min.js"></script>
    <script src="/client/assets/js/bootstrap.min.js"></script>
    <script src="/client/assets/js/amcharts-core.min.js"></script>
    <script src="/client/assets/js/amcharts.min.js"></script>
    <script src="/client/assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tab switching functionality
        $(document).ready(function() {
            // Get the hash from URL
            var hash = window.location.hash;
            
            if (hash) {
                // Show the tab corresponding to the hash
                $('.list-group-item[href="' + hash + '"]').tab('show');
            }

            // Handle tab click
            $('.list-group-item').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
                // Update URL hash
                window.location.hash = $(this).attr('href');
            });

            // Handle alerts
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '{{ session('success') }}',
                    toast: false,
                    position: 'center',
                    timer: 3000,
                    showConfirmButton: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    toast: false,
                    position: 'center',
                    timer: 4000,
                    showConfirmButton: true
                });
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Swal.fire({
                        icon: 'error',
                        title: '{{ $error }}',
                        toast: false,
                        position: 'center',
                        timer: 4000,
                        showConfirmButton: true
                    });
                @endforeach
            @endif
        });

        // Security scripts
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        });

        document.addEventListener("keydown", function(e) {
            if (
                (e.ctrlKey && (e.key === "u" || e.key === "U" || e.key === "c" || e.key === "v" || e.key === "x" || e.key === "s")) ||
                (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "i" || e.key === "J" || e.key === "j")) ||
                (e.key === "F12")
            ) {
                e.preventDefault();
            }
        });

        document.addEventListener("selectstart", function(e) {
            e.preventDefault();
        });

        document.addEventListener("dragstart", function(e) {
            e.preventDefault();
        });
    </script>

    <style>
        .list-group-item.active {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .list-group-item {
            border-left: none;
            border-right: none;
            border-radius: 0;
        }
        
        .list-group-item:first-child {
            border-top: none;
        }
        
        .badge {
            padding: 0.25em 0.6em;
            font-size: 0.85em;
        }
        
        .table th {
            font-weight: 600;
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .table-bordered td,
        .table-bordered th {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .font-weight-bold {
            font-weight: 600 !important;
        }
        
        @media (max-width: 768px) {
            .col-md-3, .col-md-9 {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
            }
        }
    </style>

</body>
</html>