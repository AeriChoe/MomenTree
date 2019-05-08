<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Profile;
use App\Like;
use App\Dislike;
use App\user;
use App\Post;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {   
        $user_id = Auth::user()->id;
        $profile = DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*', 'profiles.*')
            ->where(['profiles.user_id' => $user_id])
            ->first();
        $categories = Category::select('category')->where('user_id', $user_id)->get();
        $posts = Post::all();
        
        return view('home', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories]);
    }
    
    public function mypage() {
        $user_id = Auth::user()->id;
        $profile = DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.*', 'profiles.*')
            ->where(['profiles.user_id' => $user_id])
            ->first();
        $categories = Category::select('category')->where('user_id', $user_id)->get();
        $posts = Post::select(array('id', 'post_title', 'post_body', 'post_image', 'updated_at', 'profile_pic'))->where('user_id', $user_id)->get();
        return view('users.mypage', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories]);
    }
    
    public function user($post_userid) {
        $user_id = Auth::user()->id;
        $profile = Profile::select(array('name', 'designation', 'profile_pic'))->where('user_id', $post_userid)->first();
        $categories = Category::select('category')->where('user_id', $post_userid)->get();
        $posts = Post::select(array('id', 'post_title', 'post_body', 'post_image', 'updated_at', 'profile_pic'))->where('user_id', $post_userid)->get();
        return view('users.user', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories]);
    }
    
}
