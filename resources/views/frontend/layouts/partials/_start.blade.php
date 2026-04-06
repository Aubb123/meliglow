<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(getEnvFolder() . 'frontend/assets/img/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'others/sweetalert2/dist/sweetalert2.min.css')}}">
    <script src="{{ asset(getEnvFolder() . 'others/sweetalert2/dist/sweetalert2.all.min.js')}}"> </script>

    <!-- CSS
	============================================ -->
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/vendor/bootstrap.min.css') }}">
    <!-- Pe-icon-7-stroke CSS -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/vendor/pe-icon-7-stroke.css') }}">
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/vendor/font-awesome.min.css') }}">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/plugins/slick.min.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/plugins/animate.css') }}">
    <!-- Nice Select css -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/plugins/nice-select.css') }}">
    <!-- jquery UI css -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/plugins/jqueryui.min.css') }}">
    <!-- main style css -->
    <link rel="stylesheet" href="{{ asset(getEnvFolder() . 'frontend/assets/css/style.css') }}">

    @yield('styles')
</head>

<body>