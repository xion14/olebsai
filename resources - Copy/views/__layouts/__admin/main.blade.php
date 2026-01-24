<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('assets/image/brand/logo-brand.png') }}" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard &mdash; Olebsai</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/modules/summernote/summernote-bs4.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/panel/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/panel/css/components.css') }}">

    <link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/panel/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">


    <style>
        .dropdown-list .dropdown-list-content:not(.is-end):after {
            height: 10px !important;
        }
    </style>
    @yield('head')
</head>

<body>
    <div id="app">

        @include('__layouts.__admin.sidebar')

        @include('__layouts.__admin.header')

        @yield('body')

    </div>
    @include('__layouts.__admin.script')
    @yield('script')
</body>

</html>
