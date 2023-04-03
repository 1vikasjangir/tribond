<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Media;
use Illuminate\Support\Facades\Validator;
use Storage;
use Image;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('permission:add_blog|edit_blog|delete_blog')->only('index');
    //     $this->middleware('permission:add_blog')->only('create', 'store');
    //     $this->middleware('permission:edit_blog')->only('edit', 'update','changeStatus');
    //     $this->middleware('permission:delete_blog')->only('destroy');
    // }

    public function index(Request $request)
    {
        $blogs=Blog::query();

        // $cat = Category::where('id', $blogs->category_id)->first();

        if(isset($request->title) && $request->title != ''){
            $title = $request->title;
            $blogs->where('title','LIKE','%'.$title.'%');
        }

        // if(isset($request->category) && $request->category != ''){
        //     $category = $request->category;
        //     $blogs->where('category','LIKE','%'.$category.'%');
        // }

        if(isset($request->author) && $request->author != ''){
            $author = $request->author;
            $blogs->where('author','LIKE','%'.$author.'%');
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $blogs->where('created_at','LIKE','%'.$created_date.'%');
        }

        if(isset($request->status) && $request->status != ''){
            $status = $request->status;
            $blogs->where('status',$status);
        }

        $blogs= $blogs->orderBy('updated_at', 'DESC')->paginate(config('paginate.admin_paginate.page_count'));

        $data=compact('blogs');
        return view('admin/blog/index')->with($data);
    }

    public function categoryList(){
        $categories=Category::orderBy('id', 'DESC')
        ->get();
        $data=compact('categories');
        return view('admin/blog/add')->with($data);
    }

     public function blogsave(Request $request){
        // print_r($request->all());

        $input = $request->all();
        $input['slug']=seo_friendly_url($request['title']);

        $validator = Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
            'author'=>'required',
            'category_id'=>'required',
            'image'=>'image|required',
            'slug' => 'unique:blogs,slug'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            if($errors->has('slug')){
                return redirect()->back()->with('error', 'slug sholud be unique');
            }
        }
        $validator->validate();

        $blog=new Blog();
        $blog->title=$request['title'];
        $blog->slug=$input['slug'];
        $blog->description=$request['description'];
        $blog->author=$request['author'];
        $blog->category_id=$request['category_id'];

        if($request->hasfile('image')){
            // $file=$request->file('image');
            // $extension=$file->getClientOriginalExtension();
            // $filename=time(). '.'.$extension;
            // $filePath=public_path('uploads/blogs/');
            // $file->move($filePath, $filename);
            // $blog->image=$filename;

            $file=$request->file('image');

            $img = Image::make($file->getRealPath());
            $img->orientate();
            $img->fit(1088, 472, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $filename=$file->hashName();
            $path1 = 'blogs/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);
            $blog->image=$path;
        };
        $blog->status="1";
        $blog->save();
        return redirect('admin/blog')->with('success','You have successfully added post.');
    }

     public function delete(Request $request){
        $blog=Blog::with('getMedia')->findOrFail($request->blog_id);

        if(!is_null($blog)){
            /* Remove old image */
            $image = basename($blog->image);
            $image_path = '/blogs/'.$image;
            Storage::disk('s3')->delete($image_path);

            foreach ($blog->getMedia as $key => $media) {
                if ($media->type === 'image') {
                    // $image_path = public_path('uploads/media').'/'.$media->file;
                    // @unlink($image_path);
                    /* Remove old media image */
                    $image = basename($media->file);
                    $image_path = '/media/'.$image;
                    Storage::disk('s3')->delete($image_path);
                }
            }

            $blog->delete();
        }
        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);
        // return redirect()->back()->with('success', "You have successfully deleted!");
    }


    public function edit($id){
        $blog = Blog::findOrFail($id);
        $categories = Category::all();

        if(is_null($blog)){
            return redirect()->back();
        }else{
            return view('admin/blog/edit', compact('blog','categories'));
        }
    }

    public function update(Request $request,$id){
        // $request->validate([
        //     'title'=>'required',
        //     'description'=>'required',
        //     'author'=>'required',
        //     'category_id'=>'required',
        //     // 'image'=>'image|required'
        // ]);

        $input = $request->all();
        $input['slug']=seo_friendly_url($request['title']);

        $validator = Validator::make($input,[
            'title'=>'required',
            'description'=>'required',
            'author'=>'required',
            'category_id'=>'required',
            'slug' => [
                'required',
                Rule::unique('blogs')->ignore($id)
            ],
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            if($errors->has('slug')){
                return redirect()->back()->with('error', 'slug sholud be unique');
            }
        }
        $validator->validate();

        $blog = Blog::findOrFail($id);
        $blog->title=$request->input('title');
        $blog->slug=$input['slug'];
        $blog->description=$request->input('description');
        $blog->author=$request->input('author');
        $blog->category_id=$request['category_id'];

        if($request->hasfile('image')){
            /* Remove old image */
            $image = basename($blog->image);
            $image_path = '/blogs/'.$image;
            Storage::disk('s3')->delete($image_path);

            $file=$request->file('image');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $img->fit(1088, 472, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // $img->resize(1389, 841, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // });

            $filename=$file->hashName();
            $path1 = 'blogs/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);
            //p($path); die;
            $blog->image=$path;
        };

        $blog->update();
        return redirect('admin/blog')->with('success','You have successfully updated post.');
    }

    public function changeBlog(Request $request){
        $changeStatus=Blog::findOrFail($request->blog_id);
        $changeStatus->status = !$changeStatus->status;
        $changeStatus->update();
        return response()->json([
            'status' => $changeStatus->status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success','You have successfully changed status.');
    }
}
