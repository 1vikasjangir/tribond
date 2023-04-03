<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2 </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('adminlogin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlogin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlogin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlogin/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlogin/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlogin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('adminlogin/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('adminlogin/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <a href="{{ route('frontend.home') }}">
                                    <img src="https://dd63psqcl1xsv.cloudfront.net/images/logo.svg" alt="Logo">
                                </a>
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="fw-light">Register</h6>

                            <form action="{{ url('/') }}/register" class="pt-3" method="post">
                                @csrf
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control form-control-lg"
                                        name="name" value="{{ old('name') }}" placeholder="Name">
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" id=""
                                        class="form-control form-control-lg" placeholder="Username">
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id=""
                                        class="form-control form-control-lg" placeholder="Password">
                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="form-group">
                                    <input id="password-confirm" type="password" class="form-control form-control-lg"
                                        name="password_confirmation" placeholder="Confirm password">
                                    <span class="text-danger">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mt-3">
                                    <button
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Register</button>
                                </div>


                            </form>

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
    <script src="{{ asset('adminlogin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('adminlogin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('adminlogin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('adminlogin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('adminlogin/js/template.js') }}"></script>
    <script src="{{ asset('adminlogin/js/settings.js') }}"></script>
    <script src="{{ asset('adminlogin/js/todolist.js') }}"></script>
    <!-- endinject -->
</body>

</html>
