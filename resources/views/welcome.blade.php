<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <title>MomenTree</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Righteous" rel="stylesheet">

    <!-- FontsAwesome Icon -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="container flex flex-center">
                <div class="logo center mx-auto relative">
                    <div class="mark"></div>
                    <span class="p">M</span>
                    <span class="r">o</span>
                    <span class="e1">m</span>
                    <span class="s1">e</span>
                    <span class="s2">n</span>
                    <span class="e2">T</span>
                    <span class="e2">r</span>
                    <span class="d">e</span>
                    <span class="d">e</span>
                    <span class="d"><i class="fa fa-pagelines" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="links">
                @if (Route::has('login'))

                @auth
                <a href="{{ url('/home') }}"><button class="button button_hb button_hb-type4 demo-buttons__button">
                <span class="button__label">My page</span>
            </button></a>
                @else
                <a href="{{ route('login') }}"><button class="button button_hb button_hb-type4 demo-buttons__button">
                <span class="button__label">Login</span>
            </button></a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}"><button class="button button_hb button_hb-type5 demo-buttons__button">
                <span class="button__label">register</span>
            </button></a>
                @endif
                
                @endauth

                @endif
            </div>
        </div>
    </div>
</body>

</html>
