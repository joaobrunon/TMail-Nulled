<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TMail') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}?v={{ env('APP_VERSION') }}" rel="stylesheet">
    <link href="{{ route('CustomCss') }}" media="all" rel="stylesheet" type="text/css">
    @yield('addonCSS')
</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 tm-logo">
                    <a href="{{ route('home') }}">
                        @if(file_exists(public_path('images/custom-logo.png')))
                        <img src="{{ asset('images/custom-logo.png') }}">
                        @else 
                        <img src="{{ asset('images/logo.png') }}">
                        @endif
                    </a>
                    <div class="tm-mobile-menu-button" id="toggle">
                        <span class="top"></span><span class="middle"></span><span class="bottom"></span>
                    </div>
                </div>
                <div class="col-md-9 tm-menu">
                    <div class="row">
                        <div class="col-md-9">
                            <nav class="main">
                                <ul>
                                    <li><a {{ Request::is('admin/configuration') ? "class=active" : "class=a" }} href="{{ env('APP_URL') }}/admin/configuration">Configuration</a></li>
                                    <li><a {{ Request::is('admin/pages') ? "class=active" : "class=a" }} href="{{ env('APP_URL') }}/admin/pages">Pages</a></li>
                                    <li><a {{ Request::is('admin/menu') ? "class=active" : "class=a" }} href="{{ env('APP_URL') }}/admin/menu">Menu</a></li>
                                    <li><a {{ Request::is('admin/account') ? "class=active" : "class=a" }} href="{{ env('APP_URL') }}/admin/account">Account</a></li>
                                    <li><a {{ Request::is('admin/update') ? "class=active" : "class=a" }} href="{{ env('APP_URL') }}/admin/update">Update</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-3">
                            <nav class="social">
                                <ul>
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="#" onclick="document.getElementById('logout-form').submit();" class="top_header-button login-button googleplus">Logout</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tm-mobile-menu" id="overlay">
            <nav class="overlay-menu">
                <ul>
                    <li><a class="active" href="{{ env('APP_URL') }}/admin/configuration">Configuration</a></li>
                    <li><a href="{{ env('APP_URL') }}/admin/pages">Pages</a></li>
                    <li><a href="{{ env('APP_URL') }}/admin/menu">Menu</a></li>
                    <li><a href="{{ env('APP_URL') }}/admin/update">Update</a></li>
                    <li><a href="#" onclick="document.getElementById('logout-form').submit();" class="top_header-button login-button googleplus">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 tm-sidebar">
                    <div class="tm-stats">
                        <div class="stats-item">
                            <span class="value">{{ number_format($meta_emails_created, 0, '.', ',') }}</span>
                            <span class="title">Email IDs Generated </span>
                        </div>
                        <div class="stats-item">
                            <span class="value">{{ number_format($meta_emails_received, 0, '.', ',') }}</span>
                            <span class="title">Emails Received</span>
                        </div>
                    </div>
                    <div class="tm-ads">
                        {!! $AD_SPACE_1 !!}
                    </div>
                </div>
                <div class="col-md-9 tm-content">
                    @if(env('UPDATE_AVAILABLE'))
                        <div class="alert alert-info update_available" role="alert">
                        TMail Update Available <a href="{{ route('AdminUpdate') }}">Apply Update</a>
                        </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif 
                    @if(!$errors->isEmpty())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <strong>Oops!</strong> We encountered some errors<br>
                        @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
        <div id="snackbar"></div>
    </main>   
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    @yield('addonJS')
    <script src="{{ asset('js/scripts.js') }}?v={{ env('APP_VERSION') }}"></script>
</body>
</html>