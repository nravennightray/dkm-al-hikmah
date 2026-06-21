<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DKM AL HIKMAH')</title>

    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link href="{{ asset('assets/images/favicon.png') }}" rel="shortcut icon">

    <!-- CSS Plugins -->
    <link href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/owl-carousel/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/magnific-popup/magnific-popup.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/scrollcue/scrollcue.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <!-- Fonts/Icons -->
    <link href="{{ asset('assets/plugins/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/font-awesome/css/all.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    @include('master.layout.css')
    @yield('css')
</head>

<body class="preloader-very-peri" data-preloader="1">

    @include('master.layout.header')
    

    <main>
        @yield('content')
    </main>

    @include('master.layout.footer')

    <div class="scrolltotop icon-lg">
        <a class="button-circle button-circle-md button-circle-dark" href="#">
            <i class="bi bi-arrow-up-short"></i>
        </a>
    </div>

    @include('master.layout.js')
</body>
</html>