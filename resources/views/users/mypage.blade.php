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

                        <div class="col-md-8-post user_post">
                            @if(count($posts) > 0)
                            <hr class="hr">
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
<div id="messageForm">
    <div id="msgContact">
        <div id="closeBtn" class="fas fa-times-circle" onclick="div_hide4()"></div>
        <h2 class="popup_ti">Message ({{$msgct}})</h2>
        <ul class="msglist">
           @foreach($messageBox as $mb)
           <?php $name = $mb->name; ?>
            <li>
                <p><i class="fas fa-envelope-open-text"></i> {{$name}} : {{substr($mb->message, 0, 21)}}..</p>
            </li>
            @endforeach
            @if($msgct>1)
            <button class="showbtn" onclick="openMsg()">OPEN ALL</button>
            @else
            <button class="showbtn" onclick="openMsg()">OPEN</button>
            @endif
        </ul>

    </div>
</div>
<div id="messageForm2">
    <div id="msgContact">
    @if($msgct>1)
    @foreach($messageBox as $mb)
    <a href='{{ url("/dltMsg/{$mb->user_id}") }}' class="fas fa-times-circle" id="closeBtn2"></a>
        <h2 class="popup_ti">From {{$mb->name}}</h2>
        <ul class="msglist">
            <li>
                <p>{{$mb->message}}</p>
            </li>
        </ul>
    @endforeach
    @else
    @foreach($messageBox as $mb)
        <h2 class="popup_ti">From {{$mb->name}}</h2>
        <ul class="msglist">
            <li>
                <p>{{$mb->message}}</p>
            </li>
            <li>
                <button class="showbtn2" onclick="div_show6()">REPLY</button>
                <a href='{{ url("/dltMsg/{$mb->user_id}") }}' class="showbtn2">CLOESE</a>
            </li>
        </ul>
    @endforeach
    @endif
    </div>
</div>
<div id="messageForm3">
    <div id="msgContact">
       @foreach($messageBox as $mb)
        <a href='{{ url("/dltMsg/{$mb->user_id}") }}' class="fas fa-times-circle" id="closeBtn2"></a>
        <form method="POST" action='{{ url("/reply/{$mb->user_id}") }}' id="Mesform">
           @csrf
            <h2>Send Message to {{$mb->name}}</h2>
            <textarea id="msg" name="message" placeholder="Write here"></textarea>
            <input type="submit" class="submit" value="Send">  
        </form>
        @endforeach
    </div>
</div>
@endsection
