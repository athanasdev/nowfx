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

    <div class="vh-100 d-flex justify-content-center">
        <div class="form-access my-auto">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <span>Reset Password</span>

                <div class="form-group mb-3">
                    <input type="email" name="email" value="{{ old('email', $request->email ?? '') }}"
                        class="form-control" placeholder="Email Address" required>
                </div>

                <div class="form-group mb-3">
                    <input type="number" name="code" class="form-control" placeholder="Enter Verification Code"
                        required>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" id="new_password" class="form-control"
                        placeholder="Enter New Password" required>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        placeholder="Confirm New Password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">
                    <i class="fas fa-save"></i> Save New Password
                </button>

                <p class="mt-3 text-center">
                    Didn’t receive the code?
                    <a class="text-warning" href="{{ route('password.request') }}">Resend Again</a>
                </p>
            </form>

            <h2>Remembered your password? <a href="{{ route('register') }}">Sign in here</a></h2>
        </div>
    </div>

    <script src="/client/assets/js/jquery-3.4.1.min.js"></script>
    <script src="/client/assets/js/popper.min.js"></script>
    <script src="/client/assets/js/bootstrap.min.js"></script>
    <script src="/client/assets/js/amcharts-core.min.js"></script>
    <script src="/client/assets/js/amcharts.min.js"></script>
    <script src="/client/assets/js/custom.js"></script>
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