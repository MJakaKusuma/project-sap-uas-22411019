<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{url('vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{url('vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{url('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{url('vendors/font-awesome/css/font-awesome.min.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="{{url('images/logo.svg')}}">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            @if($errors->has('login'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif
                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-lg"
                                        autocomplete="off" id="username" placeholder="Username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="password" placeholder="Password" required>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit"
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                        SIGN IN
                                    </button>
                                </div>
                                <!-- bagian lain tetap -->
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" name="remember"> Keep me
                                            signed in </label>
                                    </div>
                                    <a href="#" class="auth-link text-primary">Forgot password?</a>
                                </div>
                            </form>
                            <script>
                                window.onload = function () {
                                    document.querySelector('input[name="username"]')?.value = '';
                                    document.querySelector('input[name="password"]')?.value = '';
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{url('vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{url('js/off-canvas.js')}}"></script>
    <script src="{{url('js/misc.js')}}"></script>
    <script src="{{url('js/settings.js')}}"></script>
    <script src="{{url('js/todolist.js')}}"></script>
    <script src="{{url('js/jquery.cookie.js')}}"></script>
    <!-- endinject -->
</body>

</html>