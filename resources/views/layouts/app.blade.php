<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @guest
    <title>MomeTree</title>
    @else
    <title>Login &#64;{{ Auth::user()->name }}</title>
    @endguest
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- FontsAwesome Icon -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/style-main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    MomenTree
                    <img src="{{ asset('images/favicon.ico') }}" alt="momentree-favicon">
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/home') }}">
                    MomenTree
                    <img src="{{ asset('images/favicon.ico') }}" alt="momentree-favicon">
                </a>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav mr-auto">
                        @guest
                        <li></li>
                        @else
                        @if(!empty($profile))
                        <li><a class="nav-link" href="{{ url('/post') }}"> Post <span class="far fa-plus-square"></span></a></li>
                        @else
                        <li></li>
                        @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        
                        @if($msgct>0)
                        <p onclick="div_show4()" style="cursor:pointer"><i class="far fa-envelope-open" style="color:darkorange; margin:10px 0 0 0; font-size:22px"></i></p>
                        @else
                        <p></p>
                        @endif
                        <a class="nav-link" href="{{ url('/mypage') }}">{{ Auth::user()->name }}</a>
                        <a class="nav-link">|</a>
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
           
            @yield('content')
            
        </main>
    </div>
<script>
    function div_show() {
        document.getElementById('abc').style.display = "block";
    }
    function div_hide() {
        document.getElementById('abc').style.display = "none";
    }
    function div_show2() {
        document.getElementById('abc2').style.display = "block";
    }
    function div_hide2() {
        document.getElementById('abc2').style.display = "none";
    }
    function div_show3() {
        document.getElementById('messageFormx').style.display = "block";
    }
    function div_hide3() {
        document.getElementById('messageFormx').style.display = "none";
    }
    function div_show4() {
        document.getElementById('messageForm').style.display = "block";
    }
    function div_hide4() {
        document.getElementById('messageForm').style.display = "none";
    }
    function openMsg() {
        document.getElementById('messageForm2').style.display = "block";
        document.getElementById('messageForm').style.display = "none";
    }
    function div_hide5() {
        document.getElementById('messageForm2').style.display = "none";
    }
    function div_show6() {
        document.getElementById('messageForm3').style.display = "block";
        document.getElementById('messageForm2').style.display = "none";
    }
    function div_hide6() {
        document.getElementById('messageForm3').style.display = "none";
    }
</script>
</body>
</html>
