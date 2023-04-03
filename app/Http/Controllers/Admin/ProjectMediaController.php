<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Storage;
use Image;

class ProjectMediaController extends Controller
{
    public function projectmedia(Request $request, $id){
        $projects = Project::where('id', $id)->first();
        $projectMedias = ProjectMedia::query();

        if (isset($request->type) && $request->type != '') {
            $type = $request->type;
            $projectMedias->where('type', $type);
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $projectMedias->where('created_at','LIKE','%'.$created_date.'%');
        }

        if (isset($request->status) && $request->status != '') {
            $status = $request->status;
            $projectMedias->where('status', $status);
        }

        $projectMedias = $projectMedias->where('project_id', $projects->id)->orderBy('updated_at', 'DESC')->paginate(config('paginate.admin_paginate.page_count'));

        return view('admin/projectMedia/index', compact('projects', 'projectMedias'));
    }

    public function saveProjectMedia(Request $request, $id){
        $request->validate([
            'image'=>'required',
        ]);

        if($request->hasFile('image'))
        {
            $allowedfileExtension=['jpg', 'jpeg', 'png'];
            // ['pdf','jpg','png','docx'];
            $files = $request->file('image');
            foreach($files as $file){
                $filename = time().rand(1,100).'.'.$file->getClientOriginalName();
                // $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension,$allowedfileExtension);
                //dd($check);
                if($check)
                {
                    foreach ($request->image as $photo) {
                        
                        $img = Image::make($photo->getRealPath());
                        $img->orientate();
                        $img->fit(1920, 1080, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        $filename=$photo->hashName();
                        $path1 = 'projects/main_image1/'.$filename;
                        $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
                        $path = Storage::disk('s3')->url($path1);
                        // $media->file=$path;

                        // $photo->move($filePath, $filename);
                        ProjectMedia::create([
                            'project_id' => $id,
                            'image' => $path,
                            'status' => '1',
                        ]);
                    }
                    return redirect()->back()->with('success', 'Media uploaded successfully');
                } else {
                    return redirect()->back()->with('success', 'Sorry Only Upload png , jpg , doc');
                }
            }
        }
    }

    public function delete(Request $request){
        $media = ProjectMedia::findOrFail($request->media_id);
        if(!is_null($media)){
            $image_path = public_path('uploads/projects/main_image').'/'.$media->file;
            @unlink($image_path);
            $media->delete();
        }
        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);
        // return redirect()->back()->with('success', "You have successfully deleted!");
    }

    public function status(Request $request){
        $mediaStatus=ProjectMedia::findOrFail($request->media_id);
        $mediaStatus->status = !$mediaStatus->status;
        $mediaStatus->update();
        return response()->json([
            'status' => $mediaStatus->status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success', "You have successfully changed status.");
     }
}
