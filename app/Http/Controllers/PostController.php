<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\Comment;
use App\Like;
use App\Dislike;
use App\Profile;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;


class PostController extends Controller
{
    public function post() {
        $user_id = Auth::user()->id;
        $categories = Category::select(array('id', 'category'))->where('user_id', $user_id)->get();
        return view('posts.post', ['categories' => $categories]);
    }
    
    public function nocate() {
        return view('posts.nocate');
    }
    
    public function addPost(Request $request) {
        $user_id = Auth::user()->id;
        $this->validate($request, [
            'post_title' => 'required',
            'post_body' => 'required',
            'category_id' => 'required',
            'post_image' => 'required',
        ]);
        
        $proinfo = Profile::select(array('name', 'profile_pic'))->where('user_id', $user_id)->get();
        foreach ($proinfo as $p) {
            $proinfoname = $p->name;
            $proinfopic = $p->profile_pic;
        }       
        $posts = new Post;
        $posts->name = $proinfoname;
        $posts->profile_pic = $proinfopic;
        $posts->post_title = $request->input('post_title');
        $posts->user_id = Auth::user()->id;
        $posts->post_body = $request->input('post_body');
        $posts->category_id = $request->input('category_id');
        
        if(Input::hasFile('post_image')) {
            $file = Input::file('post_image');
            $file->move(public_path(). '/posts', $file->getClientOriginalName());
            $url = URL::to("/") . '/posts/'. $file->getClientOriginalName();
            //return $url;
            //exit(); //<- for check
        }
        $posts->post_image = $url;
        $posts->save();
        return redirect('/home')->with('response', 'Post Published Successfully!');
    }

        
    public function view($post_id) {
        $user_id = Auth::user()->id;
        $posts = Post::where('id', '=', $post_id)->get();
        $postname = Post::select('name')->where('id', $post_id)->get();
        $likePost = Post::find($post_id);
        $likeCtr = Like::where(['post_id' => $likePost->id])->count();
        $dislikeCtr = Dislike::where(['post_id' => $likePost->id])->count();
        //return $likeCtr;
        //exit();
        $categories = Category::select(array('id', 'category'))->where('user_id', $user_id)->get();
        $comments = DB::table('users')
            ->join('comments', 'users.id', '=', 'comments.user_id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select('users.name', 'comments.*')
            ->where(['posts.id' => $post_id])
            ->get();
        
        return view('posts.view', ['posts' => $posts, 'postname' => $postname, 'categories' => $categories, 'likeCtr' => $likeCtr, 'dislikeCtr' => $dislikeCtr, 'comments' => $comments]);
    }
    
    public function edit($post_id) {
        $categories = Category::all();
        $posts = Post::find($post_id);
        $category = Category::find($posts->category_id);
        return view('posts.edit', ['categories' => $categories, 'posts' => $posts, 'category' => $category]);
        
    }

     public function editPost(Request $request, $post_id) {
         $this->validate($request, [
            'post_title' => 'required',
            'post_body' => 'required',
            'category_id' => 'required',
            'post_image' => 'required',
        ]);
        
        $posts = new Post;
        $posts->post_title = $request->input('post_title');
        $posts->user_id = Auth::user()->id;
        $posts->post_body = $request->input('post_body');
        $posts->category_id = $request->input('category_id');
        
        if(Input::hasFile('post_image')) {
            $file = Input::file('post_image');
            $file->move(public_path(). '/posts', $file->getClientOriginalName());
            $url = URL::to("/") . '/posts/'. $file->getClientOriginalName();
            //return $url;
            //exit(); //<- for check
        }
        $posts->post_image = $url;
        $data = array(
             'post_title' => $posts->post_title,
             'user_id' => $posts->user_id,
             'post_body' => $posts->post_body,
             'category_id' => $posts->category_id,
             'post_image' => $posts->post_image    
         );
         Post::where('id', $post_id)
             ->update($data);
        $posts->update();
        return redirect('/home')->with('response', 'Post Update  Successfully!');
     }
    
    public function deletePost($post_id) {
        Post::where('id', $post_id)
            ->delete();
        return redirect('/home')->with('response', 'Post Delete  Successfully!');
    }
    
    public function category($cat_id) {
        $user_id = Auth::user()->id;
        $categories = Category::select(array('id', 'category'))->where('user_id', $user_id)->get();
        $posts = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.*', 'categories.*')
            ->where(['categories.id' => $cat_id])
            ->get();
        return view('categories.categoriesposts', ['categories'=>$categories, 'posts' => $posts]);
    }
    
    public function like($id) {
        $loggedin_user = Auth::user()->id;
        $like_user = like::where(['user_id' => $loggedin_user, 'post_id' => $id])->first();
        if(empty($like_user->user_id)) {
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;
            $like = new like;
            $like->user_id = $user_id;
            $like->email = $email;
            $like->post_id = $post_id;
            $like->save();
            return redirect("/view/{$id}");
        } else {
            return redirect("/view/{$id}");
        }
    }
    
    public function dislike($id) {
        $loggedin_user = Auth::user()->id;
        $like_user = Dislike::where(['user_id' => $loggedin_user, 'post_id' => $id])->first();
        if(empty($like_user->user_id)) {
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;
            $like = new Dislike;
            $like->user_id = $user_id;
            $like->email = $email;
            $like->post_id = $post_id;
            $like->save();
            return redirect("/view/{$id}");
        } else {
            return redirect("/view/{$id}");
        }
    }
    
    public function comment(Request $request, $post_id) {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post_id;
        $comment->comment = $request->input('comment');
        $comment->save();
        return redirect("/view/{$post_id}")->with('response', 'Comment Add Successfully!');;
    }
    
    public function search(Request $request) {
        $user_id = Auth::user()->id;
        $profile = Profile::find($user_id);
        $keyword = $request->input('search');
        $posts = Post::where('post_title', 'LIKE', '%'.$keyword.'%')->get();
        $categories = Category::select('category')->where('user_id', $user_id)->get();
        return view('posts.searchposts', ['profile'=>$profile, 'posts' => $posts, 'categories' => $categories, 'keyword' => $keyword]);
    }
}


