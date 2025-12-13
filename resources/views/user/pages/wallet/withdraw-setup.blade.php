<!DOCTYPE html>
<html lang="en">


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
                        <a class="nav-link" id="settings-profile-tab" data-toggle="pill" href="#settings-profile"
                            role="tab" aria-controls="settings-profile" aria-selected="true"><i
                                class="icon ion-md-person"></i> Profile</a>
                        <a class="nav-link active" id="settings-wallet-tab" data-toggle="pill" href="#settings-wallet"
                            role="tab" aria-controls="settings-wallet" aria-selected="false"><i
                                class="icon ion-md-wallet"></i> Wallet</a>
                        <a class="nav-link" id="settings-tab" data-toggle="pill" href="#settings" role="tab"
                            aria-controls="settings" aria-selected="false"><i class="icon ion-md-settings"></i>
                            Settings</a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade " id="settings-profile" role="tabpanel"
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
                        </div>
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
                                                                    <h2>Total Balance</h2>
                                                                </div>
                                                                <div>
                                                                    <h3>{{ $user->balance }} USDT</h3>
                                                                </div>
                                                            </li>
                                                            
                                                        </ul>
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Withdraw Address Setup</h5>

                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p class="mb-3 text-muted"
                                                                    style="font-size:0.9em; text-align:left;">
                                                                    {{ __('messages.setup_form_instruction_1') }}
                                                                    {{ __('messages.setup_form_instruction_2') }}
                                                                </p>
                                                                <form action="{{ route('withdraw.setup.store') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="withdrawal_address">{{ __('messages.usdt_trc20_address_label') }}</label>
                                                                        <input type="text" id="withdrawal_address"
                                                                            name="withdrawal_address"
                                                                            class="form-control @error('withdrawal_address') is-invalid @enderror"
                                                                            value="{{ old('withdrawal_address', $currentAddress ?? '') }}"
                                                                            placeholder="{{ __('messages.placeholder_usdt_address') }}"
                                                                            required>
                                                                        @error('withdrawal_address')
                                                                            <span class="invalid-feedback"
                                                                                role="alert"><strong>{{ $message }}</strong></span>
                                                                        @enderror
                                                                        <small
                                                                            class="note">{{ __('messages.note_valid_trc20_address') }}</small>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="withdrawal_pin">{{ __('messages.create_withdrawal_pin_label') }}</label>
                                                                        <input type="password" id="withdrawal_pin"
                                                                            name="withdrawal_pin"
                                                                            class="form-control @error('withdrawal_pin') is-invalid @enderror"
                                                                            placeholder="{{ __('messages.placeholder_4_6_digit_pin') }}"
                                                                            required minlength="4" maxlength="6"
                                                                            pattern="\d*">
                                                                        @error('withdrawal_pin')
                                                                            <span class="invalid-feedback"
                                                                                role="alert"><strong>{{ $message }}</strong></span>
                                                                        @enderror
                                                                        <small
                                                                            class="note">{{ __('messages.note_secure_pin') }}</small>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="withdrawal_pin_confirmation">{{ __('messages.confirm_withdrawal_pin_label') }}</label>
                                                                        <input type="password"
                                                                            id="withdrawal_pin_confirmation"
                                                                            name="withdrawal_pin_confirmation"
                                                                            class="form-control"
                                                                            placeholder="{{ __('messages.placeholder_reenter_pin') }}"
                                                                            required>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="submit-btn mt-3 btn-success">
                                                                        save
                                                                    </button>

                                                                </form>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="/client/assets/img/qr-code-light.svg"
                                                                    alt="qr-code">
                                                            </div>
                                                        </div>
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
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

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
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

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
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

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
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

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
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

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
                                                        <a href="{{ route('deposit.form') }}"
                                                            class="btn btn-success mr-2">Deposit</a>
                                                        <a href="{{ route('withdraw') }}"
                                                            class="btn btn-danger ml-2">Withdraw</a>

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
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Change Withdrawal Address</h5>
                                    {{-- Show current address if exists --}}
                                    @if (Auth::user()->withdrawal_address)
                                        <div class="form-group">
                                            <label>Current Withdrawal Address:</label>
                                            <div class="current-address-display text-info">
                                                {{ Auth::user()->withdrawal_address }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            No withdrawal address set.
                                        </div>
                                    @endif

                                    {{-- Update Form --}}
                                    <form method="POST" action="{{ route('withdrawal.address.update') }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-group">
                                            <label for="new_withdrawal_address">New USDT (TRC20)
                                                Address:</label>
                                            <input type="text" id="new_withdrawal_address"
                                                name="new_withdrawal_address"
                                                value="{{ old('new_withdrawal_address') }}"
                                                class="form-control @error('new_withdrawal_address') is-invalid @enderror"
                                                placeholder="Enter new USDT TRC20 address" required>
                                            @error('new_withdrawal_address')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                            <small class="note text-info">Please double-check
                                                the
                                                address. Incorrect addresses may result in loss of
                                                funds.</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="withdrawal_pin">Confirm with PIN:</label>
                                            <input type="password" name="withdrawal_pin" id="withdrawal_pin"
                                                class="form-control @error('withdrawal_pin') is-invalid @enderror"
                                                placeholder="Enter your current PIN" required>
                                            @error('withdrawal_pin')
                                                <span class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                            <small class="note text-info">Enter your current
                                                withdrawal PIN
                                                to authorize this change.</small>
                                        </div>

                                        <button type="submit"
                                           class="btn btn-primary">
                                             Update Address
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card settings-profile">
                                <div class="card-body">
                                    <h5 class="card-title">Update Withdraw Password</h5>

                                    <form method="POST" action="{{ route('user.updateWithdrawPin') }}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="generateKey">Password</label>
                                                <input id="generateKey" type="password" name="withdrawal_pin"
                                                    class="form-control" placeholder="Enter your password" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="rewritePassword">Confirm password</label>
                                                <input id="rewritePassword" type="password"
                                                    name="withdrawal_pin_confirmation" class="form-control"
                                                    placeholder="Confirm your password" required>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
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


<!-- Mirrored from crypo-laravel-live.netlify.app/wallet/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Feb 2023 05:56:03 GMT -->

</html>
