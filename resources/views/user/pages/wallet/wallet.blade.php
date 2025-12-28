<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cex77 - Wallet</title>
    <link rel="icon" href="/client/assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="/client/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body id="dark">
    @include('user.pages.header')

    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Page Header -->
                    <div class="page-header mb-4">
                        <h1 class="page-title">
                            <i class="icon ion-md-wallet me-2"></i>Wallet Dashboard
                        </h1>
                        <p class="page-subtitle text-muted">Manage your funds and transactions</p>
                    </div>
                    
                    <!-- Wallet Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <div class="card summary-card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-subtitle mb-1">Total Balance</h6>
                                            <h2 class="card-title mb-0">{{ number_format($user->balance, 2) }} USD</h2>
                                        </div>
                                        <div class="icon-circle">
                                            <i class="fas fa-wallet fa-2x"></i>
                                        </div>
                                    </div>
                                    <p class="card-text mt-3 mb-0 opacity-75">Available for trading and withdrawal</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Quick Actions</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('deposit.form') }}" class="btn btn-success btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center p-4">
                                        <i class="fas fa-plus-circle fa-3x mb-3"></i>
                                        <span class="h4 mb-2">Deposit</span>
                                        <small class="text-light opacity-75">Add funds to your account</small>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('withdraw') }}" class="btn btn-danger btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center p-4">
                                        <i class="fas fa-minus-circle fa-3x mb-3"></i>
                                        <span class="h4 mb-2">Withdraw</span>
                                        <small class="text-light opacity-75">Withdraw funds from your account</small>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('trading') }}" class="btn btn-primary btn-lg w-100 h-100 d-flex flex-column justify-content-center align-items-center p-4">
                                        <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                                        <span class="h4 mb-2">Trade</span>
                                        <small class="text-light opacity-75">Start trading now</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Withdrawal Address -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <span>Withdrawal Address</span>
                                <button class="btn btn-sm btn-outline-primary" id="editAddressBtn">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                            </h5>
                            <div class="row">
                                <div class="col-md-10 mx-auto">
                                    <p class="text-muted mb-3">Your withdrawal address for sending funds. Make sure this address is correct before withdrawing.</p>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-lg" 
                                               value="{{ $user->withdrawal_address }}" 
                                               id="withdrawalAddress" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="copyAddress()">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <small>Always verify your withdrawal address before confirming transactions. This address is used for all withdrawals.</small>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-between align-items-center">
                                <span>Recent Transactions</span>
                                <a href="#" class="btn btn-outline-secondary">
                                    <i class="fas fa-history me-1"></i>View All
                                </a>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">No transactions yet</p>
                                                <small class="text-muted">Start trading to see your transaction history</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer / Navigation -->
    @include('user.common.navbar')

    <!-- Scripts -->
    <script src="/client/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/client/assets/js/popper.min.js"></script>
    <script src="/client/assets/js/bootstrap.min.js"></script>
    <script src="/client/assets/js/amcharts-core.min.js"></script>
    <script src="/client/assets/js/amcharts.min.js"></script>
    <script src="/client/assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Copy address function
            window.copyAddress = function() {
                const addressInput = document.getElementById('withdrawalAddress');
                addressInput.select();
                addressInput.setSelectionRange(0, 99999);
                
                try {
                    navigator.clipboard.writeText(addressInput.value);
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Address copied to clipboard',
                        toast: true,
                        position: 'top-end',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to copy',
                        text: 'Please try again',
                        toast: true,
                        position: 'top-end',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            };

            // Edit address button
            document.getElementById('editAddressBtn')?.addEventListener('click', function() {
                Swal.fire({
                    title: 'Edit Withdrawal Address',
                    input: 'text',
                    inputLabel: 'New withdrawal address',
                    inputValue: document.getElementById('withdrawalAddress').value,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Please enter a valid address';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Here you would typically send an AJAX request to update the address
                        // For now, we'll just update the UI
                        document.getElementById('withdrawalAddress').value = result.value;
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Withdrawal address updated successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom styles */
        .page-header {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            font-size: 1rem;
        }
        
        .summary-card {
            border-radius: 12px;
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-lg {
            padding: 1.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-lg:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        
        .qr-code-container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .table {
            background: transparent;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .table td {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }
            
            .icon-circle {
                width: 50px;
                height: 50px;
            }
            
            .icon-circle i {
                font-size: 1.5rem;
            }
            
            .btn-lg {
                padding: 1rem 0.5rem;
            }
            
            .btn-lg i.fa-3x {
                font-size: 2rem;
            }
        }
    </style>

</body>
</html>