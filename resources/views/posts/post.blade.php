<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MomeTree') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

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
                <a class="navbar-brand" href="{{ url('/') }}">
                    MomenTree
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav mr-auto">
                        <li><a class="nav-link" href="{{ url('/home') }}">My page</a></li>
                        <li><a class="nav-link" href="{{ url('/post') }}">Add Post</a></li>
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
                                <a class="dropdown-item" href='{{ url("/editPro/$profile") }}'>Update Profile</a>
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
                        <div class="card">
                            <div class="card-header">Post</div>

                            <div class="card-body">
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif


                                <form id="postform" method="POST" action="{{ url('/addPost') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="post_title" class="col-md-4 col-form-label text-md-right">{{ __(' Title') }}</label>

                                        <div class="col-md-6">
                                            <input id="post_title" type="text" class="form-control{{ $errors->has('post_title') ? ' is-invalid' : '' }}" name="post_title" value="{{ old('post_title') }}" required autofocus>

                                            @if ($errors->has('post_title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('post_title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="post_body" class="col-md-4 col-form-label text-md-right">{{ __('Post body') }}</label>

                                        <div class="col-md-6">
                                            <textarea id="post_body" rows="6" type="post_body" class="form-control{{ $errors->has('post_body') ? ' is-invalid' : '' }}" name="post_body" value="{{ old('post_body') }}" required></textarea>

                                            @if ($errors->has('post_body'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('post_body') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('category_id') }}</label>

                                        <div class="col-md-6">
                                            <select id="category_id" type="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" name="category_id" required>
                                                <option value="">Select</option>
                                                @if(count($categories) > 0)
                                                @foreach($categories->all() as $category)
                                                <option value="{{ $category->id }}">{{$category->category}}</option>

                                                @endforeach
                                                @endif

                                            </select>

                                            @if ($errors->has('category_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category_id') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="post_image" class="col-md-4 col-form-label text-md-right">Featured Image</label>

                                        <div class="col-md-6">
                                            <input id="post_image" type="file" class="form-control{{ $errors->has('post_image') ? ' is-invalid' : '' }}" name="post_image" required>

                                            @if ($errors->has('post_image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('post_image') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary btn-large btn-block">
                                                {{ __('Publish post') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
