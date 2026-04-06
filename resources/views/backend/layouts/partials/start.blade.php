<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-skin="default" data-bs-theme="light" data-assets-path="{{ asset(getEnvFolder() . 'backend/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>{{config('app.name')}} - @yield('title')</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset(getEnvFolder() . 'backend/assets/img/favicon/favicon.ico') }}">
    <!-- Fonts -->
    <link href="{{ asset(getEnvFolder() . 'backend/assets/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/fonts/iconify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/node-waves/node-waves.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/pickr/pickr-themes.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/plyr/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/css/pages/app-academy-details.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/libs/swiper/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'backend/assets/vendor/css/pages/cards-statistics.css') }}">

    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'backend/assets/js/config.js') }}"></script>

    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'others/sweetalert2/dist/sweetalert2.min.css')}}">
    <script src="{{ asset(getEnvFolder() . 'others/sweetalert2/dist/sweetalert2.all.min.js')}}"> </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'others/backend/assets/css/all.min.css') }}"> -->

    @yield('style')
    
</head>

<body>