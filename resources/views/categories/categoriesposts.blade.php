@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">


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
                                <li class="active"><a href='{{url("category/{$category->id}")}}'>{{$category->category}}</a></li>
                                @endforeach
                                @else
                                <p>No Category Found!</p>
                                @endif
                            </ul>
                        </div>

                        <div class="col-md-8-post">
                            @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                            <cite>Posted on: {{date('M j, Y H:i', strtotime($post->updated_at))}}</cite>

                        </div>
                        <div class="col-md-8-post">

                            <img src="{{$post->post_image}}" alt="image">
                            <h3>Title: {{$post->post_title}}</h3>
                            <p>{{substr($post->post_body, 0, 150)}}</p>


                            @endforeach
                            @else
                            <p>No Post..</p>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
