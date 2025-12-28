<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cex77 - Withdraw Funds</title>
    <link rel="icon" href="/client/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/client/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body id="dark">
    @include('user.pages.header')

    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="mb-2"><i class="fas fa-paper-plane text-primary mr-2"></i> Withdraw Funds</h2>
                    <p class="text-muted">Withdraw your USDT to your external wallet address</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Balance Summary -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-wallet mr-2"></i> Account Balance
                        </h5>
                        <div class="balance-display text-center py-3">
                            <h2 class="text-success mb-0">{{ number_format($user->balance, 2) }} USDT</h2>
                            <small class="text-muted">Available for withdrawal</small>
                        </div>
                    </div>
                </div>

                <!-- Withdrawal Information -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-info-circle mr-2"></i> Important Information
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Minimum withdrawal: <strong>$8 USDT</strong>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Withdrawal fee: <strong>{{ $setting->withdraw_fee_percentage ?? 5 }}%</strong>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Processing time: <strong>Up to 24 hours</strong>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Network: <strong>USDT (TRC20)</strong>
                            </li>
                            <li>
                                <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                                Ensure address is correct before submitting
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Withdrawal Form -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">
                            <i class="fas fa-money-bill-wave mr-2"></i> Withdrawal Request
                        </h5>

                        <!-- Withdrawal Form -->
                        <form method="POST" action="{{ route('withdraw.request') }}" id="withdrawalForm">
                            @csrf

                            <!-- Withdrawal Address -->
                            <div class="form-group mb-4">
                                <label for="withdrawal_address" class="form-label">
                                    <i class="fas fa-address-book mr-1"></i> Your Withdrawal Address
                                </label>
                                @php
                                    $userWithdrawalAddress = Auth::user()->withdrawal_address ?? 'No address set';
                                @endphp
                                <div class="input-group">
                                    <input type="text" 
                                           id="withdrawal_address_display" 
                                           class="form-control form-control-lg" 
                                           readonly 
                                           value="{{ $userWithdrawalAddress }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="editAddress()">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted mt-1">
                                    This is the address where your USDT will be sent
                                </small>
                            </div>

                            <!-- Amount to Withdraw -->
                            <div class="form-group mb-4">
                                <label for="amount_to_withdraw" class="form-label">
                                    <i class="fas fa-dollar-sign mr-1"></i> Amount to Withdraw
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">USDT</span>
                                    </div>
                                    <input type="number" 
                                           id="amount_to_withdraw" 
                                           name="amount" 
                                           value="{{ old('amount') }}" 
                                           step="0.01" 
                                           min="8"
                                           class="form-control form-control-lg"
                                           placeholder="Enter amount"
                                           required>
                                </div>
                                <small class="text-info">Minimum withdrawal: $8 USDT</small>
                            </div>

                            <!-- Withdrawal Summary -->
                            <div class="withdrawal-summary card bg-light border mb-4" id="withdrawalSummaryBox" style="display:none;">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Withdrawal Summary</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="mb-2">Withdrawal Amount:</p>
                                            <p class="mb-2">Fee ({{ $setting->withdraw_fee_percentage ?? 5 }}%):</p>
                                            <hr class="my-2">
                                            <p class="mb-0 font-weight-bold">You will receive:</p>
                                        </div>
                                        <div class="col-6 text-right">
                                            <p class="mb-2">$<span id="summaryAmount">0.00</span> USDT</p>
                                            <p class="mb-2 text-danger">- $<span id="summaryFee">0.00</span> USDT</p>
                                            <hr class="my-2">
                                            <p class="mb-0 font-weight-bold text-success">$<span id="summaryReceivable">0.00</span> USDT</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security PIN -->
                            <div class="form-group mb-4">
                                <label for="withdraw_password" class="form-label">
                                    <i class="fas fa-lock mr-1"></i> Security PIN
                                </label>
                                <input type="password" 
                                       name="withdraw_password" 
                                       id="withdraw_password" 
                                       class="form-control form-control-lg"
                                       placeholder="Enter your withdrawal PIN"
                                       required>
                                <small class="text-muted">Enter your 4-digit withdrawal PIN</small>
                            </div>

                            <input type="hidden" name="withdraw_currency" value="USDTTRC20">

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-danger btn-lg btn-block">
                                <i class="fas fa-paper-plane mr-2"></i> Request Withdrawal
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Recent Withdrawals (Optional) -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-history mr-2"></i> Recent Withdrawals
                        </h5>
                        <div class="text-center py-4">
                            <i class="fas fa-exchange-alt fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No withdrawal history yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/client/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/client/assets/js/popper.min.js"></script>
    <script src="/client/assets/js/bootstrap.min.js"></script>
    <script src="/client/assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Withdrawal Summary Calculator
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount_to_withdraw');
            const summaryBox = document.getElementById('withdrawalSummaryBox');
            const summaryAmount = document.getElementById('summaryAmount');
            const summaryFee = document.getElementById('summaryFee');
            const summaryReceivable = document.getElementById('summaryReceivable');

            const WITHDRAWAL_FEE_PERCENT = {{ $setting->withdraw_fee_percentage ?? 5 }} / 100;

            amountInput.addEventListener('input', function() {
                const amount = parseFloat(this.value) || 0;

                if (amount >= 8) {
                    const fee = amount * WITHDRAWAL_FEE_PERCENT;
                    const receivable = amount - fee;

                    summaryBox.style.display = 'block';
                    summaryAmount.textContent = amount.toFixed(2);
                    summaryFee.textContent = fee.toFixed(2);
                    summaryReceivable.textContent = receivable.toFixed(2);
                } else {
                    summaryBox.style.display = 'none';
                }
            });

            // Form Validation
            document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
                const amount = parseFloat(document.getElementById('amount_to_withdraw').value) || 0;
                const balance = parseFloat("{{ $user->balance }}") || 0;
                
                if (amount < 8) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Minimum Amount Required',
                        text: 'Minimum withdrawal amount is $8 USDT',
                        timer: 3000,
                        showConfirmButton: true
                    });
                } else if (amount > balance) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Insufficient Balance',
                        text: 'You cannot withdraw more than your available balance',
                        timer: 3000,
                        showConfirmButton: true
                    });
                }
            });

            // Edit Address Function
            window.editAddress = function() {
                Swal.fire({
                    title: 'Update Withdrawal Address',
                    input: 'text',
                    inputLabel: 'New USDT (TRC20) Address',
                    inputValue: document.getElementById('withdrawal_address_display').value,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Please enter a valid address';
                        }
                        if (value.length < 25) {
                            return 'Address seems too short';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Here you would typically make an AJAX call to update the address
                        // For now, we'll just update the display
                        document.getElementById('withdrawal_address_display').value = result.value;
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Address will be saved when you submit withdrawal',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            };
        });

        // Handle alerts
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>

    <style>
        /* Clean, Professional Styles */
        .page-header {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card {
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,.125);
        }
        
        .card-title {
            font-weight: 600;
            color: #2d3748;
        }
        
        .balance-display {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
        }
        
        .form-control-lg {
            height: calc(2.5em + 1rem + 2px);
        }
        
        .withdrawal-summary {
            background: linear-gradient(135deg, #fff8e1 0%, #fff3cd 100%);
            border-left: 4px solid #ffc107;
        }
        
        .btn-block {
            padding: 1rem;
            font-weight: 600;
        }
        
        .list-unstyled li {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0,0,0,.05);
        }
        
        .list-unstyled li:last-child {
            border-bottom: none;
        }
        
        /* Dark theme adjustments */
        body#dark .card {
            background: #1e1e2d;
            border-color: #2d2d43;
        }
        
        body#dark .card-title {
            color: #fff;
        }
        
        body#dark .balance-display {
            background: linear-gradient(135deg, #252541 0%, #1a1a2e 100%);
        }
        
        body#dark .withdrawal-summary {
            background: linear-gradient(135deg, #2d2d43 0%, #252541 100%);
        }
        
        body#dark .list-unstyled li {
            border-color: rgba(255, 255, 255, 0.05);
        }
        
        body#dark .bg-light {
            background: #252541 !important;
        }
        
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1rem;
            }
            
            .form-control-lg {
                font-size: 1rem;
            }
        }
    </style>

    @include('user.common.navbar')
</body>
</html>