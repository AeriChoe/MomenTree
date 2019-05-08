<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login &#64;{{ Auth::user()->name }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- FontsAwesome Icon -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

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
                <a class="navbar-brand" href="{{ url('/home') }}">
                    MomenTree
                    <img src="{{ asset('images/favicon.ico') }}" alt="momentree-favicon">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav mr-auto">
                        <li><a class="nav-link" href="{{ url('/post') }}"> Post <span class="fa fa-plus-square-o"></span></a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <?php $profile = Auth::user()->id; ?>
                                <a class="dropdown-item" href="{{ url('/mypage') }}">My page</a>
                                <a class="dropdown-item" href="{{ url('/category') }}">Category</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                        @endforeach
                        @endif

                        @if(session('response'))
                        <div class="alert alert-success">
                            {{session('response')}}
                        </div>
                        @endif
                        <div class="card">

                            @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                            <?php $postid = $post->user_id; ?>
                            @if(Auth::user()->id == $postid)
                            <div class="card-header">My Post</div>
                            @else
                            <div class="card-header"><a href='{{ url("/user/{$post->user_id}") }}' style="color:darkorange">{{$post->name}}</a>'s Post</div>
                            @endif
                            @endforeach
                            @endif

                            <div class="card-body">
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <div class="panel-body">

                                    <div class="col-md-8-post">
                                        @if(count($posts) > 0)
                                        @foreach($posts->all() as $post)
                                        <img src="{{$post->post_image}}" alt="image">
                                        <h3>Title : {{$post->post_title}}</h3>
                                        <p>{{$post->post_body }}</p>
                                    </div>
                                    <div class="col-md-8-post">
                                        <ul class="nav forview">
                                            <li role="presentation">
                                                <a href='{{ url("/like/{$post->id}") }}'>
                                                    <span class="fa fa-thumbs-up"> Like ({{$likeCtr}})</span>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href='{{ url("/dislike/{$post->id}") }}'>
                                                    <span class="fa fa-thumbs-down"> Dislike ({{$dislikeCtr}})</span>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <button class="commentbtn">
                                                    <span class="fa fa-comment-o"> Comment</span>
                                                </button>
                                            </li>

                                        </ul>
                                        @endforeach
                                        @else
                                        <p>No Post Available!</p>
                                        @endif

                                        <form method="post" action='{{ url("/comment/{$post->id}") }}' class="commentform" id="formShow">
                                            @csrf
                                            <div class="form-group">
                                                <textarea name="comment" id="comment" cols="30" rows="3" required autofocus></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-large">
                                                    {{ __('Post Comment') }}
                                                </button>
                                            </div>
                                            <div class="commentsql">
                                            @if(count($comments) > 0)
                                            <p>Comments</p>
                                            @foreach($comments->all() as $comment)
                                            <p><a href="#">{{$comment->name}}</a> : {{$comment->comment}}  <span>comment at {{$comment->updated_at}}</span></p>
                                            <br>
                                            @endforeach
                                            @else
                                            <p></p>
                                            @endif
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <script>
        $(document).ready(function() {
            $("button").click(function() {
                $("#formShow").slideToggle();
            });
        });

    </script>
</body>

</html>
