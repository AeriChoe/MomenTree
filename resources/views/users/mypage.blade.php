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
                            @if(!empty($profile))
                            <img class="avatar" src="{{ $profile->profile_pic }}" alt="Profile_picture" />
                            @else
                            <img class="avatar" src="{{ asset('images/avatar.png') }}" alt="avatar" />
                            @endif
                            <ul class="lead">
                                <?php $uppro = Auth::user()->id; ?>
                                @if(!empty($profile))
                                <li>{{ $profile->name }} <a href='{{ url("/editPro/$uppro") }}'><span class="fa fa-pencil-square-o" style="color:firebrick; font-size:24px; margin-left:5px;"></span></a></li>
                                <ul class="user_info">
                                    <li><a href=""><span class="spect">{{$post_count}}</span> post</a></li>
                                    <li><a href=""><span class="spect">{{$followct}}</span> follower</a></li>
                                    <li><a href=""><span class="spect">{{$followingct}}</span> following</a></li>
                                </ul>
                                @else
                                <p></p>
                                @endif
                                <br>
                                @if(!empty($profile))
                                <li style="margin-top:-20px;">{{ $profile->designation }}</li>
                                @else
                                <a href="{{ url('/profile') }}">Add My Profile</a>
                                @endif
                            </ul>

                            @if(!empty($profile))
                            <ul class="category">
                                <p>{{ $profile->name }}'s Category <a href="{{ url('/category') }}"><span class="fa fa-pencil-square-o" style="color:firebrick; font-size:24px; margin-left:5px;"></span></a></p>
                                @foreach($categories as $category)
                                <a href="/category">
                                    <li>#{{$category->category}}</li>
                                </a>
                                @endforeach
                            </ul>
                            @if(empty($category))
                            <ul class="category">
                                <a href="{{ url('/category') }}">Add My Category</a>
                            </ul>
                            @endif
                            @endif
                        </div>
                        <div class="col-md-8-post">
                            @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                            <hr class="hr">
                            <img src="{{$post->profile_pic}}" alt="#" class="postidimg">
                            <ul class="nav nav-pills">
                                <cite>{{date('M j, Y H:i', strtotime($post->updated_at))}} by <span style="color:darkorange; font-size: 22px;">{{$post->name}}</span></cite>
                                <li role="presentation">
                                    <a href='{{ url("/view/{$post->id}") }}'>
                                        <span class="fa fa-eye"> View</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href='{{ url("/edit/{$post->id}") }}'>
                                        <span class="fa fa-pencil-square-o"> Edit</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href='{{ url("/delete/{$post->id}") }}'>
                                        <span class="fa fa-trash"> Delete</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="col-md-8-post">

                            <img src="{{$post->post_image}}" alt="image">
                            <h3>Title: {{$post->post_title}}</h3>
                            <p>{{substr($post->post_body, 0, 150)}}</p>


                            @endforeach
                            @else
                            <span></span>
                            @endif



                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
