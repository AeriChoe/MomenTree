@extends('layouts.app')

@section('content')
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
                <div class="card-header">
                    <div class="col-md-8 mainHeader">
                        <p class="fa fa-search"></p>
                        <form method="POST" action="{{ url('/search') }}" id="searchForm">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search for..." required>

                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                        Go!
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="panel-body">
                        <div class="profile">
                            <img class="avatar" src="{{ $profile->profile_pic }}" alt="Profile_picture" />
                            <ul class="lead">

                                @if(empty($checkfollow))
                                <li>{{ $profile->name }}
                                    <button class="follow-btn">
                                        <a href='{{ url("/follow/{$profile->id}") }}'>Follow</a></button>
                                    <a href=""><span class="fa fa-envelope-o" style="color:tomato; font-size:30px;"></span></a>
                                </li>
                                @else
                                <li>{{ $profile->name }}
                                    <button class="follow-btn2">
                                        <a href='{{ url("/unfollow/{$profile->id}") }}'>Following</a></button>
                                    <a href=""><span class="fa fa-envelope-o" style="color:tomato; font-size:30px;"></span></a>
                                </li>
                                @endif
                                <ul class="user_info">
                                    <li><a href="#"><span class="spect">{{$post_count}}</span> post</a></li>
                                    <li><a href="#"><span class="spect">{{$followct}}</span> follower</a></li>
                                    <li><a href="#"><span class="spect">{{$followingct}}</span> following</a></li>
                                </ul>
                                <li>{{ $profile->designation }}</li>
                            </ul>

                            <ul class="category2">
                                <p>{{ $profile->name }}'s Category</p>
                                @foreach($categories as $category)
                                <li>#{{$category->category}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <hr class="hr">
                        <div class="col-md-8-post user_post">
                            @foreach($posts->all() as $post)
                              <div class="user_post_one">
                                <a href='{{ url("/view/{$post->id}") }}'><img src="{{$post->post_image}}" alt="post_image"></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
