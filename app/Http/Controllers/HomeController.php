<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Follow;
use App\Profile;
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
        $posts = Post::orderBy('updated_at', 'desc')->get();
        
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
        $posts = Post::select(array('id', 'post_title', 'post_body', 'post_image', 'updated_at', 'profile_pic'))->where('user_id', $user_id)->orderBy('updated_at', 'desc')->get();
        $post_count = Post::where('user_id', $user_id)->count();
        $followct = Follow::where('following_user_id', $user_id)->count();
        $followingct = Follow::where('user_id', $user_id)->count();
        
        return view('users.mypage', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories, 'post_count' => $post_count, 'followct' => $followct, 'followingct' => $followingct]);
    }
    
    public function user($post_userid) {
        $user_id = Auth::user()->id;
        $profile = Profile::select(array('id', 'name', 'designation', 'profile_pic'))->where('user_id', $post_userid)->first();
        $categories = Category::select('category')->where('user_id', $post_userid)->get();
        $posts = Post::select(array('id', 'post_title', 'post_body', 'post_image', 'updated_at', 'profile_pic'))->where('user_id', $post_userid)->orderBy('updated_at', 'desc')->get();
        $post_count = Post::where('user_id', $post_userid)->count();
        $checkfollow = Follow::select('following_user_id')->where('following_user_id', $post_userid)->where('user_id', $user_id)->first();
        $followct = Follow::where('following_user_id', $post_userid)->count();
        $followingct = Follow::where('user_id', $post_userid)->count();
        
        return view('users.user', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories, 'post_count' => $post_count, 'checkfollow' => $checkfollow, 'followct' => $followct, 'followingct' => $followingct]);
    }
    
    public function follow($following_userid) {
        $user_id = Auth::user()->id; 
        $loggined_info = Profile::select(array('name', 'profile_pic'))->where('user_id', $user_id)->get();
        foreach ($loggined_info as $li) {
            $liname = $li->name;
            $lipic = $li->profile_pic;
        }
        $following_info = Profile::select(array('user_id', 'name', 'profile_pic'))->where('id', $following_userid)->get();
        foreach ($following_info as $fi) {
            $fiid = $fi->user_id;
            $finame = $fi->name;
            $fipic = $fi->profile_pic;
        }
        $followuser = new Follow;
        $followuser->user_id = Auth::user()->id;
        $followuser->name = $liname;
        $followuser->profile_pic = $lipic;
        $followuser->following_user_id = $fiid;
        $followuser->following_name = $finame;
        $followuser->following_profile_pic = $fipic;
        $followuser->save();
        
        return redirect("/user/{$following_userid}")->with('response', 'Following ' . $finame . ' now!');
        
    }
    public function unfollow($following_userid) {
        Follow::where('following_user_id', $following_userid)->delete();
        
        return redirect("/user/{$following_userid}");
    }
    
}
