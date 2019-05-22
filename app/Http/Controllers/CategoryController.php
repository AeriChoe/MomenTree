<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Contact;
use Auth;

class CategoryController extends Controller
{
    public function category() {
        $user_id = Auth::user()->id;
        $categories = Category::select(array('id', 'category'))->where('user_id', $user_id)->get();
        $msgct = Contact::where('to_user_id', $user_id)->count(); 
        
        return view('categories.category', ['categories' => $categories, 'msgct' => $msgct]);
      }

    public function addCategory(Request $request) {
        $this->validate($request, [
          'category' => 'required'
        ]);
        $category = new Category;
        $category->user_id = Auth::user()->id;
        $category->category = $request->input('category');
        $category->save();
        return redirect('/category')->with('response', 'Category Added Succefully');
      }
    
    public function deleteCategory($cat_id) {
        Category::where('id', $cat_id)
            ->delete();
        return redirect('/category')->with('response', 'Category Delete Succefully');
    }

}
