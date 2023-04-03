<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Blog;

use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::query();

        if (isset($request->title) && $request->title != '') {
            $title = $request->title;
            $categories->where('title','LIKE','%'.$title.'%');
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $categories->where('created_at','LIKE','%'.$created_date.'%');
        }

        if (isset($request->status) && $request->status != '') {
            $status = $request->status;
            $categories->where('status', $status);
        }

        $categories = $categories->orderBy('updated_at', 'DESC')->paginate(config('paginate.admin_paginate.page_count'));
        $data = compact('categories');
        return view('admin/category/index')->with($data);
    }

    public function add(){
        return view('admin/category/add');
    }

    public function insert(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        $category=new Category();
        $category->title=$request['title'];
        $category->description=$request['description'];
        $category->status="1";

        $category->save();
        return redirect('admin/category')->with('success','You have successfully added data.');
    }

    //   public function view(){
    //      $categories=Category::all();
    //     // echo "<pre>";
    //    //   print_r( $categories);
    //      $data=compact('categories');
    //      return view('category-view')->with($data);
    //   }

    public function delete(Request $request){
        $category=Category::findOrFail($request->category_id);
        if(!is_null($category))
        {
            $category->delete();
        }
        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);
        // return redirect()->back()->with('success', "You have successfully deleted!");
    }

     public function edit($id){
      $category=Category::findOrFail($id);

      if(is_null($category)){
         return redirect()->back();
         //not found
      }else{
         $updateurl=url('/update-data')."/".$id;
         return view('admin/category/edit',compact('category'));
      }

     }

     public function update(Request $request, $id){
      $request->validate([
         'title'=>'required',
         'description'=>'required'
        ]);
      $category=Category::findOrFail($id);
      $category->title=$request->input('title');
      $category->description=$request['description'];
      $category->update();
      return redirect('admin/category')->with('success','You have successfully updated data.');
     }

     public function status(Request $request){
        $categoryDetail = Category::findOrFail($request->category_id);
        $categoryDetail->status = !$categoryDetail->status;
        $categoryDetail->update();
        return response()->json([
            'status' => $categoryDetail->status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success','You have successfully changed status.');
     }
}
