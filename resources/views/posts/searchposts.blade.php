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
                    <div class="col-md-8 searchHeader">
                        <p style="margin:0px; font-size:20px;">Search Keyword : <a href="#" style="font-size:24px;">{{$keyword}}</a></p>
                        
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="panel-body">
                        <div class="col-md-8-post">
                           
                            @if(count($posts) > 0)

                            <?php $userid = Auth::user()->id; ?>
                            @foreach($posts->all() as $post)
                            <?php $postuserid = $post->user_id; ?>
                            @if($userid == $postuserid)
                            <img src="{{$post->profile_pic}}" alt="" class="postidimg">
                            <ul class="nav nav-pills">
                                <cite>{{date('M j, Y H:i', strtotime($post->updated_at))}} by <a href='{{ url("/mypage") }}' style="color:darkorange; font-size: 22px;">{{$post->name}}</a></cite>
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
                            <img src="{{$post->profile_pic}}" alt="#" class="postidimg">
                            <ul class="nav nav-pills">
                                <cite>{{date('M j, Y H:i', strtotime($post->updated_at))}} by <a href='{{ url("/user/{$post->user_id}") }}' style="color:darkorange; font-size: 22px;">{{$post->name}}</a></cite>
                                <li role="presentation">
                                    <a href='{{ url("/view/{$post->id}") }}'>
                                        <span class="fa fa-heart"> View this Post</span>
                                    </a>
                                </li>
                            </ul>

                            @endif
                        </div>
                        <div class="col-md-8-post">

                            <img src="{{$post->post_image}}" alt="image">
                            <h3>Title: {{$post->post_title}}</h3>
                            <p>{{substr($post->post_body, 0, 150)}}</p>

                            <hr class="hr">
                            @endforeach
                            @else
                            <p>No Post not yet!</p>
                            @endif



                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
