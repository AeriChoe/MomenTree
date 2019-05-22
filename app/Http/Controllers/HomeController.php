<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Contact;
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
        $messageBox = Contact::select(array('user_id', 'name', 'message'))->where('to_user_id', $user_id)->get();
        $msgct = Contact::where('to_user_id', $user_id)->count(); 
        
        return view('home', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories, 'messageBox' => $messageBox ,'msgct' => $msgct]);
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
        $followinguser = Follow::select(array('following_user_id','following_name', 'following_profile_pic'))->where('user_id', $user_id)->get();
        $followeruser = Follow::select(array('user_id','name', 'profile_pic'))->where('following_user_id', $user_id)->get();
        $messageBox = Contact::select(array('user_id', 'name', 'message'))->where('to_user_id', $user_id)->get();
        
        $msgct = Contact::where('to_user_id', $user_id)->count();
        $post_count = Post::where('user_id', $user_id)->count();
        $followct = Follow::where('following_user_id', $user_id)->count();
        $followingct = Follow::where('user_id', $user_id)->count();
        
        return view('users.mypage', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories, 'post_count' => $post_count, 'followct' => $followct, 'followingct' => $followingct, 'followinguser' => $followinguser, 'followeruser' => $followeruser, 'messageBox' => $messageBox ,'msgct' => $msgct]);
    }
    
    public function user($post_userid) {
        $user_id = Auth::user()->id;
        $profile = Profile::select(array('id', 'name', 'designation', 'profile_pic'))->where('user_id', $post_userid)->first();
        $categories = Category::select('category')->where('user_id', $post_userid)->get();
        $posts = Post::select(array('id', 'post_title', 'post_body', 'post_image', 'updated_at', 'profile_pic'))->where('user_id', $post_userid)->orderBy('updated_at', 'desc')->get();
        $post_count = Post::where('user_id', $post_userid)->count();
        $checkfollow = Follow::select('following_user_id')->where('following_user_id', $post_userid)->where('user_id', $user_id)->first();
        $followinguser = Follow::select(array('following_user_id','following_name', 'following_profile_pic'))->where('user_id', $post_userid)->get();
        $followeruser = Follow::select(array('user_id','name', 'profile_pic'))->where('following_user_id', $post_userid)->get();
        $messageBox = Contact::select(array('user_id', 'name', 'message'))->where('to_user_id', $user_id)->get();
        
        $msgct = Contact::where('to_user_id', $user_id)->count(); 
        $followct = Follow::where('following_user_id', $post_userid)->count();
        $followingct = Follow::where('user_id', $post_userid)->count();
        
        return view('users.user', ['profile' => $profile, 'posts' => $posts, 'categories' => $categories, 'post_count' => $post_count, 'checkfollow' => $checkfollow, 'followct' => $followct, 'followingct' => $followingct, 'followinguser' => $followinguser, 'followeruser' => $followeruser,'messageBox' => $messageBox ,'msgct' => $msgct]);
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
    
    public function sendMsg(Request $request, $userid) {
        $user_id = Auth::user()->id;
        $myprofile = Profile::where('user_id', $user_id)->get();
        foreach ($myprofile as $mp) {
            $name = $mp->name;
        }
        $userprofile = Profile::where('user_id', $userid)->get();
        foreach ($userprofile as $up) {
            $username = $up->name;
        }
        $this->validate($request, [
            'message' => 'required'
        ]);
        $cotact = new Contact;
        $cotact->user_id = $user_id;
        $cotact->name = $name;
        $cotact->message = $request->input('message');
        $cotact->to_user_id = $userid;
        $cotact->to_name = $username;
        $cotact->save();
            
        return redirect("/user/{$userid}")->with('response', 'Success to send a message!');
    }
    
    public function deleteMsg($userid) {
        $user_id = Auth::user()->id;
        Contact::where('to_user_id', $user_id)->delete();
        
        return redirect("home");
    }
    
    public function replyMsg(Request $request, $userid) {
        $user_id = Auth::user()->id;
        $myprofile = Profile::where('user_id', $user_id)->get();
        foreach ($myprofile as $mp) {
            $name = $mp->name;
        }
        $userprofile = Profile::where('user_id', $userid)->get();
        foreach ($userprofile as $up) {
            $username = $up->name;
        }
        $this->validate($request, [
            'message' => 'required'
        ]);
        $cotact = new Contact;
        $cotact->user_id = $user_id;
        $cotact->name = $name;
        $cotact->message = $request->input('message');
        $cotact->to_user_id = $userid;
        $cotact->to_name = $username;
        $cotact->save();
        Contact::where('to_user_id', $user_id)->delete();
            
        return redirect("home")->with('response', 'Success to send a message!');
    }
}
