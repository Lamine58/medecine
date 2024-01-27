<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/images/icon.png")}}">

    <!-- Layout config Js -->
    <script src="{{asset("assets/js/layout.js")}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset("assets/css/app.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset("assets/css/custom.min.css")}}" rel="stylesheet" type="text/css" />

</head>

<style>
    .auth-one-bg {
        background-image: url('{{asset("assets/images/bg.jpg")}}');
        background-position: center;
        background-size: cover;
    }
    .auth-one-bg .bg-overlay {
        background: transparent;
        opacity: 0;
    }
</style>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        
        @yield('content')

        {{-- <!-- footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                <img style="width:100px" src="{{asset('images/zodiac.png')}}" alt="">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer> --}}
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("assets/libs/simplebar/simplebar.min.js")}}"></script>
    <script src="{{asset("assets/libs/node-waves/waves.min.js")}}"></script>
    <script src="{{asset("assets/libs/feather-icons/feather.min.js")}}"></script>
    <script src="{{asset("assets/js/pages/plugins/lord-icon-2.1.0.js")}}"></script>
    <script src="{{asset("assets/js/plugins.js")}}"></script>

    <!-- particles js -->
    <script src="{{asset("assets/libs/particles.js/particles.js")}}"></script>
    <!-- particles app js -->
    <script src="{{asset("assets/js/pages/particles.app.js")}}"></script>
    <!-- validation init -->
    <script src="{{asset("assets/js/pages/form-validation.init.js")}}"></script>
    <!-- password create init -->
    <script src="{{asset("assets/js/pages/passowrd-create.init.js")}}"></script>

    @yield('script')
</body>


</html>