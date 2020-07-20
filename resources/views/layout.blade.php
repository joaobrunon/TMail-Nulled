<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('custom_header')
    <title>{{ config('app.name', 'TMail') }}</title>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}?v={{ env('APP_VERSION') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Favicon -->
    @if(file_exists(public_path('images/custom-favicon.png')))
    <link rel="icon" href="{{ asset('images/custom-favicon.png') }}" type="image/png">
    @else 
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}?v={{ env('APP_VERSION') }}" rel="stylesheet">
    <link href="{{ route('CustomCss') }}" media="all" rel="stylesheet" type="text/css">
    {!! $CUSTOM_HEADER !!}
    @yield('addonCSS')
    <style>
        {!! $CUSTOM_CSS !!}
    </style>
</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 tm-logo">
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
                <div class="col-xl-9 tm-menu">
                    <div class="row">
                        <div class="col-xl-9">
                            <nav class="main">
                                <ul>
                                    @foreach(App\Menu::where('status', true)->get() as $menu)
                                        @if($menu->new_tab) 
                                            <li><a href="{{ $menu->link }}" target="_blank">{{ $menu->name }}</a></li>
                                        @else 
                                            <li><a href="{{ $menu->link }}">{{ $menu->name }}</a></li>
                                        @endif
                                    @endforeach
                                    @if(Auth::check())
                                    <li class="special"><a href="{{ env('APP_URL') }}/admin">Admin Panel</a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        <div class="col-xl-3">
                            <nav class="social">
                                <ul>
                                    @if(env('FACEBOOK_URL', ''))
                                    <li><a class="facebook" href="{{ env('FACEBOOK_URL', '#') }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if(env('TWITTER_URL', ''))
                                    <li><a class="twitter" href="{{ env('TWITTER_URL', '#') }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if(env('YOUTUBE_URL', ''))
                                    <li><a class="youtube" href="{{ env('YOUTUBE_URL', '#') }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                    <li>
                                        <select id="locale" name="locale">
                                            @foreach(config('app.locales') as $locale)
                                            <option {{ (app()->getLocale() == $locale ) ? "selected" : "" }}>{{ $locale }}</option>
                                            @endforeach
                                        </select>
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
                    @foreach(App\Menu::where('status', true)->get() as $menu)
                        @if($menu->new_tab) 
                            <li><a href="{{ $menu->link }}" target="_blank">{{ $menu->name }}</a></li>
                        @else 
                            <li><a href="{{ $menu->link }}">{{ $menu->name }}</a></li>
                        @endif
                    @endforeach
                    @if(Auth::check())
                    <li class="special"><a href="{{ env('APP_URL') }}/admin">Admin Panel</a></li>
                    @endif
                </ul>
            </nav>
            <div class="social-language-mobile">
                <div class="social">
                    @if(env('FACEBOOK_URL', ''))
                    <a class="facebook" href="{{ env('FACEBOOK_URL', '#') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(env('TWITTER_URL', ''))
                    <a class="twitter" href="{{ env('TWITTER_URL', '#') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(env('YOUTUBE_URL', ''))
                    <a class="youtube" href="{{ env('YOUTUBE_URL', '#') }}" target="_blank"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
                <select id="locale" name="locale">
                    @foreach(config('app.locales') as $locale)
                        <option {{ (app()->getLocale() == $locale ) ? "selected" : "" }}>{{ $locale }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
        <div id="snackbar"></div>
    </main>   
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    @yield('addonJS')
    <script src="{{ asset('js/shortcode.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script>
        {!! $CUSTOM_JS !!}
    </script>
</body>
</html>