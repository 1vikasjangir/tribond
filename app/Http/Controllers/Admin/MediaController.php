<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\Media;
use Illuminate\Support\Facades\Validator;
use Storage;
use Image;

// use BenSampo\Embed\Rules\EmbeddableUrl;

class MediaController extends Controller
{

    public function blogmedia(Request $request, $id){
        $blogs = Blog::where('id', $id)->first();
        $medias = Media::query();

        if (isset($request->type) && $request->type != '') {
            $type = $request->type;
            $medias->where('type', $type);
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $medias->where('created_at','LIKE','%'.$created_date.'%');
        }

        if (isset($request->status) && $request->status != '') {
            $status = $request->status;
            $medias->where('status', $status);
        }

        $medias = $medias->where('blog_id', $blogs->id)->orderBy('updated_at','DESC')->paginate(config('paginate.admin_paginate.page_count'));

        return view('admin/media/index', compact('medias','blogs'));
    }

    public function savemedia(Request $request, $id){
        if($request['type'] == "image"){
            $request->validate([
                'image' => 'image|required',
            ]);
        }else{
            $request->validate([
                'video' => [
                    'required',
                    'url',
                    // (new EmbeddableUrl)->allowedServices([
                    //     YouTube::class,
                    //     Vimeo::class
                    // ])
                ],
            ]);
        }

        $media=new Media();
        $media->blog_id= (int)$id;
        $media->type=$request['type'];
        if ($request['type'] == 'image') {
            if($request->hasfile('image')){
                $file=$request->file('image');
                $img = Image::make($file->getRealPath());
                $img->orientate();
                $img->fit(1389, 841, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $filename=$file->hashName();
                $path1 = 'blogs/media/'.$filename;
                $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
                $path = Storage::disk('s3')->url($path1);
                $media->file=$path;
            };
        } else {
            $media->file=$request['video'];
        }

        $media->status="1";
        $media->save();
      return redirect()->back()->with('success','You have successfully added data.');
    }

    public function delete(Request $request){
        // p($request->media_id); die;
        $media = Media::findOrFail($request->media_id);
        if(!is_null($media)){
            /* Remove old media image */
            $image = basename($media->file);
            $image_path = '/blogs/media/'.$image;
            Storage::disk('s3')->delete($image_path);

            $media->delete();
        }

        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);

        // return redirect()->back()->with('success', "You have successfully deleted!");
    }

    public function status(Request $request){
        // p($request->media_id); die;
        $mediaStatus=Media::findOrFail($request->media_id);
        $mediaStatus->status = !$mediaStatus->status;
        $mediaStatus->update();
        return response()->json([
            'status' => $mediaStatus->status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success', "You have successfully changed status.");
    }

    public function showMediaAboveDesc(Request $request){
        $mediaStatus=Blog::where('id', $request->blog_id)->first();
        if($mediaStatus->media_above_desc=="0"){
            $media_above_desc="1";
        } else {
            $media_above_desc="0";
        }

        $mediaStatus->update(['media_above_desc'=>$media_above_desc]);
        return response()->json([
            'data' => [
                'status' => true,
                'success' => $request->media_above_desc,
            ]
        ]);
    }

}
