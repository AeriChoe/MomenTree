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
                                <li>{{ $profile->name }} <a href='{{ url("/editPro/$uppro") }}'><span class="fas fa-edit" style="color:firebrick; font-size:24px; margin-left:5px;"></span></a>
                                </li>
                                <ul class="user_info">
                                    <li><a href=""><span class="spect">{{$post_count}}</span> post</a></li>
                                    <li onclick="div_show2()"><span class="spect">{{$followct}}</span> follower</li>
                                    <li onclick="div_show()"><span class="spect">{{$followingct}}</span> following</li>
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
                                <p>{{ $profile->name }}'s Category <a href="{{ url('/category') }}"><span class="fas fa-edit" style="color:firebrick; font-size:24px; margin-left:5px;"></span></a></p>
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

                        <hr class="hr">
                        <div class="col-md-8-post user_post">
                            @if(count($posts) > 0)
                            @foreach($posts->all() as $post)

                            <div class="user_post_one">
                                <a href='{{ url("/edit/{$post->id}") }}'>
                                    <span class="far fa-edit" style="margin-left:80%"></span>
                                </a>
                                <a href='{{ url("/delete/{$post->id}") }}'>
                                    <span class="far fa-trash-alt" style="margin-left:8px"></span>
                                </a>
                                <a href='{{ url("/view/{$post->id}") }}'><img src="{{$post->post_image}}" alt="post_image"></a>

                            </div>
                            @endforeach
                        </div>
                        @else
                        <span></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="abc">
    <div id="popupContact">
        <div id="closepopup" class="fas fa-times-circle" onclick="div_hide()"></div>
        <h2 class="popup_ti">Following list</h2>
        <ul class="followlist">
            @foreach($followinguser as $fuser)
            <li><a href='{{ url("/user/{$fuser->following_user_id}") }}'><img src="{{$fuser->following_profile_pic}}" alt="user_profile_pic">
                    <p>{{$fuser->following_name}}</p>
                </a>
            </li>
            @endforeach
        </ul>

    </div>
</div>
<div id="abc2">
    <div id="popupContact">
        <div id="closepopup" class="fas fa-times-circle" onclick="div_hide2()"></div>
        <h2 class="popup_ti">Follower list</h2>
        <ul class="followlist">
            @foreach($followeruser as $flwer)
            <li><a href='{{ url("/user/{$flwer->user_id}") }}'><img src="{{$flwer->profile_pic}}" alt="user_profile_pic">
                    <p>{{$flwer->name}}</p>
                </a>
            </li>
            @endforeach
        </ul>

    </div>
</div>
@endsection
