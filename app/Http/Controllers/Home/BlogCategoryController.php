<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use PDO;
use Image;

class BlogCategoryController extends Controller
{
    //
    public function AllBlogCategory() {
        $blogcategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogcategory'));

    }//end method

    public function AddBlogCategory() {
        return view('admin.blog_category.blog_category_add');

    }//end method

    public function StoreBlogCategory(Request $request) {
        // $request->validate([
        //     'blog_category' => 'required', 
        // ], [
        //     'blog_category.required' => 'Blog Category is required',     
        // ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
        ]); 
            $notification = array(
            'message' => 'Blog Category inserted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);


    }//end method 

    public function EditBlogCategory($id) {
        $blogcategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit',compact('blogcategory'));

    }//end method

    public function UpdateBlogCategory(Request $request,$id) {

        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
        ]); 
            $notification = array(
            'message' => 'Blog Category inserted Successfully', 
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);

    }

    public function DeleteBlogCategory($id) {

        BlogCategory::findOrFail($id)->delete();
        $notification = array(
           'message' => 'Blog Category Deleted Successfully', 
           'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);

    }//end method
}
