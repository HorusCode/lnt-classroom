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
<body class="bg--purple-gradient">

<div id="app" class="grid-login">
    <div class="card rad-1 login-card">
        <div class="card-media">
            <div class="image">
                <img src="{{ asset('images/login-image.jpg') }}" alt="Login please">
            </div>
        </div>
        <div class="card-content">
            <header class="card-header">
                <h1 class="text-title text-primary">Tetra</h1>
                <h3 class="text-subtitle text-secondary">Class management system for colleges</h3>
            </header>
            <login-form-cards></login-form-cards>
        </div>
    </div>
</div>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
<script>
  import Clients from '../assets/js/components/Clients';
  export default {
    components: {Clients},
  };
</script>