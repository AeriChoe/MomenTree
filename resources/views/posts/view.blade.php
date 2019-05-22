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

                @if(count($posts) > 0)
                @foreach($posts->all() as $post)
                <?php $postid = $post->user_id; ?>
                @if(Auth::user()->id == $postid)
                <div class="card-header">My Post
                @foreach($showcate as $sc)
                <p class="postcate">Category : {{$sc->category}}</p>
                </div>
                @endforeach
                @else
                <div class="card-header">
                <a href='{{ url("/user/{$post->user_id}") }}' style="color:darkorange">{{$post->name}}</a>'s Post
                @foreach($showcate as $sc)
                <p class="postcate">Category : {{$sc->category}}</p>
                @endforeach
                </div>
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

                        <div class="col-md-8-post viewpost">
                            @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                            
                            <img src="{{$post->post_image}}" alt="image">
                            <cite>{{date('M j, Y H:i', strtotime($post->updated_at))}}</cite>
                            <h3>Title : {{$post->post_title}}</h3>
                            <p>{{$post->post_body }}</p>
                        </div>
                        <div class="col-md-8-post">
                            <ul class="nav forview">
                                <li role="presentation">
                                    <a href='{{ url("/like/{$post->id}") }}'>
                                        <span class="far fa-thumbs-up"> Like ({{$likeCtr}})</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href='{{ url("/dislike/{$post->id}") }}'>
                                        <span class="far fa-thumbs-down"> Dislike ({{$dislikeCtr}})</span>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <button class="commentbtn">
                                        <span class="far fa-comment-alt"> Comment({{$commeCtr}})</span>
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
                                    @if(Auth::user()->id == $comment->user_id)
                                    <p><a href='{{ url("/mypage") }}'>
                                    @foreach($myp as $mp)
                                    {{$mp->name}}</a><span>&#40;{{date('M j', strtotime($comment->updated_at))}}&#41;</span> : {{$comment->comment}} <span></span></p>
                                    @endforeach
                                    @else
                                    <p><a href='{{ url("/user/{$comment->user_id}") }}'>
                                    @foreach($myp as $mp)
                                    {{$mp->name}}</a><span>&#40;{{date('M j', strtotime($comment->updated_at))}}&#41;</span> : {{$comment->comment}} </p>
                                    @endforeach
                                    @endif
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
<script>
    $(document).ready(function() {
        $("button").click(function() {
            $("#formShow").slideToggle();
        });
    });

</script>
@endsection
