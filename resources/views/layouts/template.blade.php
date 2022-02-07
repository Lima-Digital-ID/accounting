<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com/polygon/admindek/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:07:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<!-- /Added by HTTrack -->

<head>
    <title>Admindek | Admin Template</title>


    <!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="colorlib" />

    <link rel="icon" href="https://colorlib.com/polygon/admindek/files/assets/images/favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/waves.min.css') }}" type="text/css" media="all">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome-n.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/chartist.css') }}" type="text/css" media="all">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widget.css') }}">
    @stack('css')
</head>

<body>

    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

           @include('components.partials.topbar')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    @include('components.partials.sidebar')

                    @yield('content')

                    <div id="styleSelector">
                    </div>

                </div>
            </div>
        </div>
    </div>




    <script data-cfasync="false" src="{{ asset('assets/js/email-decode.min.js') }}"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/waves.min.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>

    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.flot.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.flot.categories.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script src="{{ asset('assets/js/curvedlines.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.flot.tooltip.min.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>

    <script src="{{ asset('assets/js/chartist.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>

    <script src="{{ asset('assets/js/amcharts.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script src="{{ asset('assets/js/serial.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script src="{{ asset('assets/js/light.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>

    <script src="{{ asset('assets/js/pcoded.min.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script src="{{ asset('assets/js/vertical-layout.min.js') }}" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/custom-dashboard.min.js') }}"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript" src="{{ asset('assets/js/script.min.js') }}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="d2d1d6e2f87cbebdf4013b26-text/javascript"></script>
    <script type="d2d1d6e2f87cbebdf4013b26-text/javascript">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script src="{{ asset('assets/js/rocket-loader.min.js') }}" data-cf-settings="d2d1d6e2f87cbebdf4013b26-|49" defer=""></script>
    @stack('js')
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:08:25 GMT -->

</html>
