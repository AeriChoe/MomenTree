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
                <div class="card-header">My page</div>

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
                                @if(!empty($profile))
                                <li>{{ $profile->name }}</li>
                                @else
                                <p></p>
                                @endif
                                <br>
                                @if(!empty($profile))
                                <li>{{ $profile->designation }}</li>
                                @else
                                <p>No Information</p>
                                @endif
                            </ul>
                            
                            @if(!empty($profile))
                            <ul class="category">
                                @if(count($categories) > 0)
                                <p>{{ $profile->name }}'s Category</p>
                                @foreach($categories->all() as $category)
                                <a href="/category"><li>#{{$category->category}}</li></a>
                                @endforeach
                                @endif
                            </ul>
                            @endif
                        </div>
                        
                        <div class="col-md-8-post">
                            @if(count($posts) > 0)
                            <?php $userid = Auth::user()->id; ?>
                            @foreach($posts->all() as $post)
                            <?php $postuserid = $post->user_id; ?>
                            <hr class="hr">
                            @if($userid == $postuserid)
                            <cite>Posted on: {{date('M j, Y H:i', strtotime($post->updated_at))}}</cite>
                            <ul class="nav nav-pills">
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
                            @else
                            
                            <cite>Posted on: {{date('M j, Y H:i', strtotime($post->updated_at))}}</cite>
                            
                            @endif
                        </div>
                        <div class="col-md-8-post">

                            <img src="{{$post->post_image}}" alt="image">
                            <h3>Title: {{$post->post_title}}</h3>
                            <p>{{substr($post->post_body, 0, 150)}}....</p>


                            @endforeach
                            @else
                            <p>No Post Available!</p>
                            @endif
                            
                           

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
