<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') </title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="grid-main">
    <!--Header-->
    @include('includes.header')
    <!--Endheader-->
    <!--Sidebar-->
    @include('includes.sidebar')
    <!--EndSidebar-->
    <!--Content-->
    <main class="content">
        @yield('content')
    </main>
    <!--EndContent-->
    <!--Footer-->
    @include('includes.footer')
    <!--EndFooter-->
</div>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>