<!DOCTYPE html>
<html lang="en">
<head>
    <title>Multikart PWA App</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Multikart">
    <meta name="keywords" content="Multikart">
    <meta name="author" content="Multikart">
    <!-- <link rel="manifest" href="./manifest.json"> -->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/images/favicon.png">
    <meta name="theme-color" content="#ff4c3b" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="multikart">
    <meta name="msapplication-TileImage" content="assets/images/favicon.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    @viteReactRefresh
    @routes
    @vite('resources/js/app.jsx')
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/video-js.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"> -->
    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{ asset('front-assets/css/vendors/bootstrap.css') }}">
    <!-- slick css -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/vendors/slick.css') }}"> -->
    <!-- iconly css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/vendors/iconly.css') }}">
    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="{{ asset('front-assets/css/style.css') }}">
</head>
<body>
    @inertia
    <!-- <script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.stripe.com/v3/"></script> -->
    <script src="{{ asset('front-assets/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('front-assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Slick js-->
    <script src="{{ asset('front-assets/js/slick.js') }}"></script>
    <!-- Slick js-->
    <!-- <script src="{{ asset('front-assets/js/homescreen-popup.js') }}"></script> -->
    <!-- timer js-->
    <!-- <script src="{{ asset('front-assets/js/timer.js') }}"></script> -->
    <!-- offcanvas modal js -->
    <script src="{{ asset('front-assets/js/offcanvas-popup.js') }}"></script>
    <!-- script js -->
    <!-- <script src="{{ asset('front-assets/js/script.js') }}"></script> -->
</body>
</html>