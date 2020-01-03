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

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg--purple-gradient">

<div id="login" class="grid-login">
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
            <div class="card login-form-card">
                <div class="card-content">
                    <header class="card-header">
                        <h3 class="text-center mx-1"><span class="text-primary">Login</span> your account</h3>
                    </header>
                    <form  action="">
                        <div class="input-line">
                            <label for="login" class="input-label">Login</label>
                            <div class="input-group">
                                <span class="mdi mdi-login-variant pos-left"></span>
                                <input type="text" id="login" class="input">
                            </div>
                        </div>
                        <div class="input-line">
                            <label for="password" class="input-label">Password</label>
                            <div class="input-group">
                                <span class="mdi mdi-textbox-password pos-left"></span>
                                <input type="text" id="password" class="input">
                                <span class="mdi mdi-eye-outline pos-right text-muted"></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="label-link">Is this your first time?</span>
                            <span class="label-link">Forget password?</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mx-1">
                            <button type="submit" class="btn btn-primary width-3">Login</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>