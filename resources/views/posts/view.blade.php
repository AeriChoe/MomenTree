@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Post View</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="panel-body">
                        <div class="col-md-8-post">
                            <ul class="view-category">
                                @if(count($categories) > 0)
                                @foreach($categories->all() as $category)
                                <li><a href='{{url("category/{$category->id}")}}'>{{$category->category}}</a></li>
                                @endforeach
                                @else
                                <p>No Category Found!</p>
                                @endif
                            </ul>
                        </div>

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
                                    <a href='{{ url("/comment/{$post->id}") }}'>
                                        <span class="fa fa-comment-o"> Comment</span>
                                    </a>
                                </li>

                            </ul>
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
