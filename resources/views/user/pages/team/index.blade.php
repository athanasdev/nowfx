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

    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade" id="settings-profile" role="tabpanel"
                            aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">General Information</h5>
                                    <div class="settings-profile">
                                        <form action="#">
                                            <img src="/client/assets/img/avatar.svg" alt="avatar">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="fileUpload"
                                                    required />
                                                <label class="custom-file-label" for="fileUpload">Choose avatar</label>
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
                                    <div class="col-md-10 col-lg-10 mx-auto">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="coinBTC" role="tabpanel">

                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Teams</h5>
                                                        <div class="row wallet-address">
                                                            <div class="col-md-8">
                                                                <p>When friend A registers with your registration link,
                                                                    he becomes your first-level member. You can get 12%
                                                                    commission from each of his trade services fees

                                                                    When friend B registers with friend A's Registration
                                                                    link, he becomes friend A's first-level member and
                                                                    your second-level member at the same time. So every
                                                                    time friend B trades, friend A can earn 12%
                                                                    commission for each transaction service fee. You
                                                                    will also earn 6% commission on each of his trade
                                                                    service fees.

                                                                    When Friend C uses the friend B Registration linkto
                                                                    register as a first-level member of friend B, a
                                                                    second-level member of friend A, and also your
                                                                    third-level member. Friend B can earn 12% commission
                                                                    per trade, friend A can earn 6% commission per trade
                                                                    service fee, and you can earn 3% commission from his
                                                                    each trade service fee.</p>
                                                                    
                                                                <h3>Invitation code: </h3>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        id="referralLinkInput"
                                                                        value="{{ $user->referral_code }}"
                                                                        readonly>
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary" type="button"
                                                                            onclick="copyReferralLink()">COPY</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- MY TEAMS --}}
                                                {{-- <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">My Teams</h5>
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
                                                </div> --}}

                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">My Teams</h5>
                                                        <div class="wallet-history">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Level</th>
                                                                        <th>Members</th>
                                                                        {{-- <th>Deposits</th> --}}
                                                                        <th>Commissions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td>Level 1</td>
                                                                        <td>{{ $level1_count }}</td>
                                                                        {{-- <td>{{ $level1_deposit }}</td> --}}
                                                                        <td>{{ $level1_commissions }} USD</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>Level 2</td>
                                                                        <td>{{ $level2_count }}</td>
                                                                        {{-- <td>{{ $level2_deposit }}</td> --}}
                                                                        <td>{{ $level2_commissions }} USD</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>Level 3</td>
                                                                        <td>{{ $level3_count }}</td>
                                                                        {{-- <td>{{ $level3_deposit }}</td> --}}
                                                                        <td>{{ $level3_commissions }} USD</td>
                                                                    </tr>
                                                                    <tr class="font-weight-bold">
                                                                        <td colspan="2">Total</td>
                                                                        <td>{{ $total_registered_users }}</td>
                                                                        {{-- <td>{{ $total_deposits }}</td> --}}
                                                                        <td>{{ $total_commissions }} USD</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card" style="margin-top: 20px;">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            <i class="fas fa-list-ul"></i> My Referred Users
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="text-align:center; width:5%;">#</th>
                                                                        <th>Username</th>
                                                                        <th style="text-align:center;">Level</th>
                                                                        <th style="text-align:right;">Balance (USDT)
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($paginatedMembers as $index => $member)
                                                                        <tr>
                                                                            <td style="text-align:center;">
                                                                                {{ $paginatedMembers->firstItem() + $index }}
                                                                            </td>
                                                                            <td>{{ $member->username }}</td>
                                                                            <td style="text-align:center;">
                                                                                {{ $member->level }}</td>
                                                                            <td style="text-align:right;">
                                                                                ${{ number_format($member->balance, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="4"
                                                                                style="text-align:center; padding:20px; color:#848e9c;">
                                                                                No referred users yet
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <!-- Pagination -->
                                                        <div
                                                            class="d-flex justify-content-center mt-3 pagination-wrapper">
                                                            {{ $paginatedMembers->links('vendor.pagination.custom') }}
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

    <script>
        function copyReferralLink() {
            const input = document.getElementById('referralLinkInput');
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');

            alert('Referral link copied to clipboard!');
        }
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
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '{{ session('error') }}',
                    toast: true,
                    position: 'top-end',
                    timer: 4000,
                    showConfirmButton: false
                });
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Swal.fire({
                        icon: 'error',
                        title: '{{ $error }}',
                        toast: true,
                        position: 'top-end',
                        timer: 4000,
                        showConfirmButton: false
                    });
                @endforeach
            @endif
        });
    </script>

</body>



</html>