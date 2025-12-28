<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cex77 - Deposit</title>
    <link rel="icon" href="/client/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/client/assets/css/style.css">
</head>

<body id="dark">
    @include('user.pages.header')

    <div class="container-fluid mtb15">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="page-header mb-4">
                    <h2><i class="icon ion-md-wallet"></i> Deposit Funds</h2>
                    <p class="text-muted">Add funds to your account using USDT (TRC20)</p>
                </div>

                <!-- Balance Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Account Balance</h5>
                        <div class="d-flex align-items-center">
                            <i class="icon ion-md-cash mr-3" style="font-size: 2rem;"></i>
                            <div>
                                <h3 class="mb-0">{{ number_format($user->balance, 2) }} USDT</h3>
                                <p class="text-muted mb-0">Available balance</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deposit Section -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Make a Deposit</h5>
                        
                        <!-- Show FORM if no payment data -->
                        @if (!isset($paymentData))
                        <form method="POST" action="{{ route('payments.create') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <label for="price_amount" class="form-label">Amount (USD):</label>
                                <input type="number" id="price_amount" name="price_amount" 
                                       class="form-control form-control-lg" step="0.01" min="15" required
                                       placeholder="Enter amount">
                                <small class="form-text text-info">Minimum deposit is $15</small>
                            </div>

                            <input type="hidden" name="price_currency" value="usd">
                            <input type="hidden" name="order_description" value="deposit">
                            <input type="hidden" name="ipn_callback_url" value="{{ url('/ipn-callback') }}">
                            <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="order_id" value="{{ auth()->id() }}">
                            <input type="hidden" id="pay_currency" name="pay_currency" value="usdttrc20">

                            <div class="alert alert-info">
                                <i class="icon ion-md-information-circle-outline"></i>
                                <strong>Note:</strong> Deposit using USDT TRC20 network only
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">
                                <i class="fas fa-arrow-circle-right mr-2"></i> Proceed to Deposit
                            </button>
                        </form>
                        @else
                        <!-- Show QR Code + Payment Info -->
                        <div class="payment-info">
                            <div class="text-center mb-4">
                                <h4><i class="fas fa-coins"></i> Payment Details</h4>
                                <div class="alert alert-warning">
                                    Please send exactly <strong>{{ $paymentData['price_amount'] }} {{ strtoupper($paymentData['pay_currency']) }}</strong>
                                </div>
                            </div>

                            <!-- QR Code -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h6>Scan QR Code</h6>
                                            <div id="qrcode-box" class="mt-3 mb-3"></div>
                                            <small class="text-muted">Scan with your wallet app</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Payment Address</h6>
                                            <div class="input-group mb-3">
                                                <input type="text" id="paymentAddressInput" class="form-control" 
                                                       readonly value="{{ $paymentData['pay_address'] }}">
                                                <button type="button" onclick="copyPaymentAddress()" 
                                                        class="btn btn-secondary">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                            <div id="copyFeedbackDisplay" class="text-success small"></div>
                                            
                                            <div class="payment-details mt-4">
                                                <p><strong>Network:</strong> {{ $paymentData['network'] }}</p>
                                                <p><strong>Payment ID:</strong> {{ $paymentData['payment_id'] }}</p>
                                                <p><strong>Status:</strong> <span class="text-warning">Waiting</span></p>
                                                <p><strong>Valid Until:</strong> {{ $paymentData['valid_until'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                Your deposit will be processed automatically after 3 network confirmations
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Important Information -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Important Information</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Only send USDT on TRC20 network
                            </li>
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Minimum deposit: $15 USD
                            </li>
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Deposits are processed automatically
                            </li>
                            <li class="list-group-item bg-transparent">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                Contact support if deposit doesn't appear within 30 minutes
                            </li>
                        </ul>
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
    
    <!-- QR Code Generator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Copy payment address
        function copyPaymentAddress() {
            const input = document.getElementById("paymentAddressInput");
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand("copy");
            
            document.getElementById("copyFeedbackDisplay").innerText = "✓ Address copied to clipboard";
            setTimeout(() => {
                document.getElementById("copyFeedbackDisplay").innerText = "";
            }, 3000);
        }

        // Generate QR Code if address exists
        @if (isset($paymentData))
            new QRCode(document.getElementById("qrcode-box"), {
                text: "{{ $paymentData['pay_address'] }}",
                width: 200,
                height: 200,
                colorDark: "#000000",
                colorLight: "#ffffff"
            });
        @endif

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
        .page-header {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .form-control-lg {
            height: calc(2.5em + 1rem + 2px);
        }
        
        .btn-block {
            padding: 0.75rem 1rem;
        }
        
        .payment-info {
            max-width: 800px;
            margin: 0 auto;
        }
        
        #qrcode-box {
            display: inline-block;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        
        .list-group-item {
            border-color: rgba(255, 255, 255, 0.1);
            background: transparent;
        }
        
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1rem;
            }
            
            #qrcode-box {
                width: 150px;
                height: 150px;
            }
            
            #qrcode-box img {
                width: 100%;
                height: 100%;
            }
        }
    </style>

    @include('user.common.navbar')
</body>
</html>