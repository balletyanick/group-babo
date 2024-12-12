<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/images/babo.png")}}">

    <!-- Layout config Js -->
    <script src="{{asset("assets/js/layout.js")}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset("assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset("assets/css/app.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset("assettes/css/custom.min.css")}}" rel="stylesheet" type="text/css" />

    <!-- New strat-->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/babo-white.png')}}">
    <link href={{asset("assettes/css/style.css")}} rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
    <!-- New end-->

</head>

<style>
    .auth-one-bg {
        background-image: url('{{asset("assets/images/expert-assurance.jpeg")}}');
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
        @yield('content')
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

    <!-- New strat-->
    <script src={{asset("assettes/vendor/global/global.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/vendor/bootstrap-select/dist/js/bootstrap-select.min.js")}} type="text/javascript"></script>
    <script src={{asset("assettes/js/custom.js") }} type="text/javascript"></script>
    <script src={{asset("assettes/js/deznav-init.js") }} type="text/javascript"></script>
    <!-- New end-->

    @yield('script')
</body>


</html>