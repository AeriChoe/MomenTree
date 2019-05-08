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
                    <div class="col-md-8">
                        <ul>
                            <li>Follower</li>
                            <li>Following</li>
                            <li>Contact</li>
                        </ul> 
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
                                <li>{{ $profile->name }}</li>
                                <li>{{ $profile->designation }}</li>
                            </ul>

                            
                            <ul class="category2">
                                <p>{{ $profile->name }}'s Category</p>
                                @foreach($categories as $category)
                                    <li>#{{$category->category}}</li>
                                @endforeach
                            </ul>                            
                        </div>

                        <div class="col-md-8-post">
                            @foreach($posts->all() as $post)
                            <hr class="hr">
                        
                            <img src="{{$post->profile_pic}}" alt="#" class="postidimg">
                            <ul class="nav nav-pills">
                                <cite>{{date('M j, Y H:i', strtotime($post->updated_at))}} by <a href='{{ url("/user/{$post->user_id}") }}' style="color:darkorange; font-size: 22px;">{{$post->name}}</a></cite>
                                <li role="presentation">
                                    <a href='{{ url("/view/{$post->id}") }}'>
                                        <span class="fa fa-heart"> View this Post</span>
                                    </a>
                                </li>
                            </ul>


                        </div>
                        <div class="col-md-8-post">

                            <img src="{{$post->post_image}}" alt="image">
                            <h3>Title: {{$post->post_title}}</h3>
                            <p>{{substr($post->post_body, 0, 150)}}</p>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
