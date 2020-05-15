<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(Request::is('messages'))
    <meta http-equiv="refresh" content="30"/>
    @endif
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title') - TMail Installer</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{ env('APP_VERSION') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png?v='.env('APP_VERSION')) }}" type="image/png" sizes="64x64">
    
    <!-- Font Awesome v5.5.0 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
        crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css?v='.env('APP_VERSION')) }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css?v='.env('APP_VERSION')) }}" rel="stylesheet">
    <link href="{{ asset('css/installer/styles.css?v='.env('APP_VERSION')) }}" rel="stylesheet">
    @yield('pageCSS')
</head>
<body>
    <div class="container header">
        <div class="row">
            <div class="col-lg-12 logo">
                <a href="/"><img src="{{ asset('images/installer/logo.png?v='.env('APP_VERSION')) }}"></a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    @if(!$errors->isEmpty())
                    <div class="alert alert-danger fade show" role="alert">
                        <strong>Oops!</strong> We encountered some errors<br>
                        @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                        @endforeach
                    </div>
                    @endif
                    @if(isset($message))
                    <div class="alert alert-success fade show" role="alert">
                        <strong>Oops!</strong> We encountered some errors<br>
                        {{ $message }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @yield('content')
    </div>
    @yield('pageJS')
    @yield('addonJS')
</body>
</html>
