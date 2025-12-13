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
                        <a class="nav-link active" id="settings-wallet-tab" data-toggle="pill" href="#settings-wallet"
                            role="tab" aria-controls="settings-wallet" aria-selected="false"><i
                                class="icon ion-md-wallet"></i> Depost</a>

                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="settings-wallet" role="tabpanel"
                            aria-labelledby="settings-wallet-tab">
                            <div class="wallet">
                                <div class="row">
                                    <div class="col-md-12 col-lg-10">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="coinBTC" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Balalnce</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>{{ $user->balance }} USDT</h3>
                                                                </div>
                                                            </li>

                                                        </ul>

                                                    </div>
                                                </div>


                                                {{-- DEPOST PAGE HERE IS --}}

                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Deposit</h5>



                                                        {{-- Show FORM if no payment data --}}
                                                        @if (!isset($paymentData))
                                                            <form method="POST"
                                                                action="{{ route('payments.create') }}">
                                                                @csrf

                                                                <div class="form-group">
                                                                    <label for="price_amount">Amount (USD):</label>
                                                                    <input type="number" id="price_amount"
                                                                        name="price_amount" class="form-control"
                                                                        step="0.01" min="15" required>
                                                                    <small class="note text-info">Minimum deposit is
                                                                        $15</small>
                                                                </div>

                                                                <input type="hidden" name="price_currency"
                                                                    value="usd">
                                                                <input type="hidden" name="order_description"
                                                                    value="deposit">
                                                                <input type="hidden" name="ipn_callback_url"
                                                                    value="{{ url('/ipn-callback') }}">
                                                                <input type="hidden" name="customer_email"
                                                                    value="{{ auth()->user()->email }}">
                                                                <input type="hidden" name="order_id"
                                                                    value="{{ auth()->id() }}">

                                                                <div class="form-group">
                                                                    {{-- <label for="pay_currency">Pay with Crypto:</label> --}}
                                                                    {{-- <select  id="pay_currency" name="pay_currency"
                                                                        class="form-control" required>
                                                                        <option   value="usdttrc20">USDT (TRC20)</option>
                                                                    </select> --}}
                                                                    <input type="hidden" id="pay_currency"
                                                                        name="pay_currency" value="usdttrc20">

                                                                    <small class="note text-info"><strong>Note:</strong>
                                                                        Make depost using USDT TRC20
                                                                        network</small>
                                                                </div>

                                                                <button type="submit"
                                                                    class="submit-btn mt-3 btn-rounded btn-success">
                                                                    <i class="fas fa-arrow-circle-right"></i> Proceed
                                                                    to Deposit
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{-- Show QR Code + Payment Info --}}
                                                            <div class="payment-page-container">
                                                                <div class="payment-card-container">
                                                                    <h2><i class="fas fa-coins"></i> Deposit Payment
                                                                    </h2>

                                                                    <div class="instructions">
                                                                        Please send
                                                                        <strong>{{ $paymentData['price_amount'] }}
                                                                            {{ strtoupper($paymentData['pay_currency']) }}</strong>
                                                                        to the address below:
                                                                        <br>
                                                                        <small>Order ID:
                                                                            {{ $paymentData['order_id'] }}</small>
                                                                    </div>

                                                                    {{-- ✅ QR Code --}}
                                                                    <div id="qrcode-box" class="mt-3"></div>

                                                                    {{-- ✅ Payment Address with Copy Button --}}
                                                                    <div class="address-container mt-3">
                                                                        <input type="text" id="paymentAddressInput"
                                                                            class="form-control" readonly
                                                                            value="{{ $paymentData['pay_address'] }}">
                                                                        <button type="button"
                                                                            onclick="copyPaymentAddress()"
                                                                            class="btn btn-secondary mt-2">
                                                                            <i class="fas fa-copy"></i> Copy Address
                                                                        </button>
                                                                    </div>
                                                                    <div id="copyFeedbackDisplay"
                                                                        class="copy-feedback mt-2 text-success"></div>

                                                                    <div class="payment-details mt-3">
                                                                        <p><strong>Network:</strong>
                                                                            {{ $paymentData['network'] }}</p>
                                                                        <p><strong>Payment ID:</strong>
                                                                            {{ $paymentData['payment_id'] }}</p>
                                                                        <p><strong
                                                                                style="color: yellow, text-color:yellow
                                                                        ">Status:</strong>
                                                                            Waiting</p>
                                                                        <p><strong></strong>
                                                                            {{ $paymentData['valid_until'] }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="coinETH" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Equity</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>4.1542 ETH</h3>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-checkmark"></i>
                                                                    <h2>Available Margin</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>1.334 ETH</h3>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <button class="btn green">Deposit</button>
                                                        <button class="btn red">Withdraw</button>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Wallet Deposit Address</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>Deposits to this address are unlimited. Note that you
                                                                    may not be able to withdraw all
                                                                    of your
                                                                    funds at once if you deposit more than your daily
                                                                    withdrawal limit.</p>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="Ad87deD4gEe8dG57Ede4eEg5dREs4d5e8f4e">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
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
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>25-04-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>4.5454334</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>25-05-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>0.5484468</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-06-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>25-07-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>1.45894147</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-08-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="coinBNB" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Equity</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>7.342 BNB</h3>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-checkmark"></i>
                                                                    <h2>Available Margin</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>0.332 BNB</h3>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <button class="btn green">Deposit</button>
                                                        <button class="btn red">Withdraw</button>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Wallet Deposit Address</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>Deposits to this address are unlimited. Note that you
                                                                    may not be able to withdraw all
                                                                    of your
                                                                    funds at once if you deposit more than your daily
                                                                    withdrawal limit.</p>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="Ad87deD4gEe8dG57Ede4eEg5dREs4d5e8f4e">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
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
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>25-04-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>4.5454334</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>25-05-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>0.5484468</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-06-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>25-07-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>1.45894147</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-08-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="coinTRX" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Equity</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>4.3344 TRX</h3>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-checkmark"></i>
                                                                    <h2>Available Margin</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>1.453 TRX</h3>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <button class="btn green">Deposit</button>
                                                        <button class="btn red">Withdraw</button>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Wallet Deposit Address</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>Deposits to this address are unlimited. Note that you
                                                                    may not be able to withdraw all
                                                                    of your
                                                                    funds at once if you deposit more than your daily
                                                                    withdrawal limit.</p>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="Ad87deD4gEe8dG57Ede4eEg5dREs4d5e8f4e">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
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
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>25-04-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>4.5454334</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>25-05-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>0.5484468</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-06-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>25-07-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>1.45894147</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-08-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="coinEOS" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Equity</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>33.35 EOS</h3>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-checkmark"></i>
                                                                    <h2>Available Margin</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>4.445 EOS</h3>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <button class="btn green">Deposit</button>
                                                        <button class="btn red">Withdraw</button>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Wallet Deposit Address</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>Deposits to this address are unlimited. Note that you
                                                                    may not be able to withdraw all
                                                                    of your
                                                                    funds at once if you deposit more than your daily
                                                                    withdrawal limit.</p>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="Ad87deD4gEe8dG57Ede4eEg5dREs4d5e8f4e">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
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
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>25-04-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>4.5454334</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>25-05-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>0.5484468</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-06-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>25-07-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>1.45894147</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-08-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="coinXMR" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Equity</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>34.333 XMR</h3>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-checkmark"></i>
                                                                    <h2>Available Margin</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>2.354 XMR</h3>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <button class="btn green">Deposit</button>
                                                        <button class="btn red">Withdraw</button>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Wallet Deposit Address</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>Deposits to this address are unlimited. Note that you
                                                                    may not be able to withdraw all
                                                                    of your
                                                                    funds at once if you deposit more than your daily
                                                                    withdrawal limit.</p>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="Ad87deD4gEe8dG57Ede4eEg5dREs4d5e8f4e">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
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
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>25-04-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>4.5454334</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>25-05-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>0.5484468</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-06-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>25-07-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>1.45894147</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-08-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="coinKCS" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Balances</h5>
                                                        <ul>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-cash"></i>
                                                                    <h2>Total Equity</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>86.577 KCS</h3>
                                                                </div>
                                                            </li>
                                                            <li
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icon ion-md-checkmark"></i>
                                                                    <h2>Available Margin</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>5.78 KCS</h3>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <button class="btn green">Deposit</button>
                                                        <button class="btn red">Withdraw</button>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Wallet Deposit Address</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>Deposits to this address are unlimited. Note that you
                                                                    may not be able to withdraw all
                                                                    of your
                                                                    funds at once if you deposit more than your daily
                                                                    withdrawal limit.</p>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        value="Ad87deD4gEe8dG57Ede4eEg5dREs4d5e8f4e">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
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
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>25-04-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>4.5454334</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>25-05-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>0.5484468</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-06-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td>25-07-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-checkmark-circle-outline green"></i>
                                                                        </td>
                                                                        <td>1.45894147</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>25-08-2019</td>
                                                                        <td><i
                                                                                class="icon ion-md-close-circle-outline red"></i>
                                                                        </td>
                                                                        <td>2.5454545</td>
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

    {{-- QR Code Generator & Copy Function --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Copy payment address
        function copyPaymentAddress() {
            const input = document.getElementById("paymentAddressInput");
            input.select();
            input.setSelectionRange(0, 99999); // For mobile
            document.execCommand("copy");

            document.getElementById("copyFeedbackDisplay").innerText = "✅ Address copied!";
        }

        // Generate QR Code if address exists
        @if (isset($paymentData))
            new QRCode(document.getElementById("qrcode-box"), {
                text: "{{ $paymentData['pay_address'] }}",
                width: 200,
                height: 200
            });
        @endif
    </script>

    <!-- Include SweetAlert2 and Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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


@include('user.common.navbar')


</body>


</html>