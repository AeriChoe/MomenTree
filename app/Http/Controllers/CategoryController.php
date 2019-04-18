<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    public function category() {
        $categories = Category::all();
        return view('categories.category', ['categories' => $categories]);
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
