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
                                                            <form method="POST" action="{{ route('bot.close_trade') }}"
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
                                toast: false,
                                position: 'center',
                                timer: 5000,
                                showConfirmButton: true
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
                                toast: false,
                                position: 'center',
                                timer: 5000,
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

