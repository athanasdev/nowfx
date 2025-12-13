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

    @include('user.pages.header')

    <div class="vh-100 d-flex justify-content-center">
        <div class="form-access my-auto">
            <form class="form-signin" action="{{ route('user.login') }}" method="POST">
                @csrf
                <span>Sign In</span>

                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required />
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required />
                </div>
                <div class="text-right">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="form-checkbox">
                    <label class="custom-control-label" for="form-checkbox">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            <h2>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></h2>
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '{{ session("success") }}',
            toast: true,
            position: 'top-end',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '{{ session("error") }}',
            toast: true,
            position: 'top-end',
            timer: 4000,
            showConfirmButton: false
        });
    @endif

    @if($errors->any())
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

@include('user.common.navbar')


</body>



</html>
