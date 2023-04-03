<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \RecursiveIteratorIterator;
use \RecursiveDirectoryIterator;
use File;
use Storage;
use ZipArchive;
use Illuminate\Support\Facades\Validator;
use App\Models\Video;
use Image;

class VideoController extends Controller
{
    public function index(Request $request){
        $videos = Video::query();

        if (isset($request->name) && $request->name != '') {
            $name = $request->name;
            $videos->where('name','LIKE','%'.$name.'%');
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $videos->where('created_at','LIKE','%'.$created_date.'%');
        }

        if (isset($request->status) && $request->status != '') {
            $status = $request->status;
            $videos->where('status', $status);
        }

        $videos = $videos->orderBy('updated_at', 'DESC')->paginate(config('paginate.admin_paginate.page_count'));

        return view('/admin/video/index', compact('videos'));
    }

    public function videoform(){
        return view('/admin/video/add');
    }

    public function videosave(Request $request){
        $request->validate([
            'name'=>'required',
            'zip'=>'required|mimes:zip',
            'thumbnail'=>'required|image'
        ]);

        $video=new Video();
        $video->name=$request['name'];
        $video->status="1";

        $zip = new ZipArchive();
        $status = $zip->open($request->file("zip")->getRealPath());

        if ($status !== true) {
            throw new \Exception($status);
        } else {
            $fileOrigionalName = $request->file("zip")->getClientOriginalName();
            $zipName = explode('.', $fileOrigionalName);
            $fileName = seo_friendly_url($zipName[0]);
            // $fileName = str_replace('_', '-', $zipName[0]);

            //$pathroot = public_path("vr/$fileName");
            $storageDestinationPath= public_path("vr/$fileName");

            if (!File::isDirectory($storageDestinationPath)) {

                if (!\File::exists( $storageDestinationPath)) {
                    \File::makeDirectory($storageDestinationPath, 0777, true);
                }

                $zip->extractTo($storageDestinationPath);

                $dir = $storageDestinationPath;

                // $files1 = scandir($dir);
                $files1 = array_diff(scandir($dir), array('..', '.'));
                // p($files1);die;

                foreach ($files1 as $key => $file) {
                    if ($file == "index.htm") {
                        $newPath = $storageDestinationPath."/index.html";
                        $oldPath = $storageDestinationPath."/".$file;
                        rename($oldPath, $newPath);
                    }
                }

                $zip->close();

                $file=$request->file('zip');
                $extension=$file->getClientOriginalExtension();
                $filename=$fileName. '.'.$extension;
                $video->url=url("vr/$filename");

                $video->save();

                // return redirect('admin/video/')->with('success','You have successfully extracted zip.');
            } else {
                return back()->with('error', "can't upload zip with same name");
            }
        }

        if($request->hasfile('thumbnail')){
            $file=$request->file('thumbnail');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $filename=$file->hashName();
            $path1 = 'vr/thumbnails/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);
            $video->thumbnail=$path;
        };

        $video->save();
        return redirect('admin/video')->with('success','Data added successfully.');
    }

    public function delete(Request $request) {
        $video=Video::findOrFail($request->video_id);
        if(!is_null($video))
        {
            $fileName = $video->url;
            $tmp = explode('/', $fileName);
            $lastElement = end($tmp);
            $zipName = explode('.', $lastElement);
            if(file_exists(public_path("vr/$zipName[0]"))){
                $path = public_path()."/vr/".$zipName[0];
                File::deleteDirectory($path);
            } else {
                return redirect()->back()->with('error', "File does not exists.");
            }
            $video->delete();
        }
        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);
        // return redirect()->back()->with('success', "You have successfully deleted!");
    }

    public function status(Request $request){
        $videoStatus=video::findOrFail($request->video_id);

        if($videoStatus->status=="1"){
            $status="0";
        }
        else{
            $status="1";
        }
        $videoStatus->update(['status'=>$status]);
        return response()->json([
            'status' => $status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success','You have successfully changed status.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.video.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
        ]);

        $video = Video::findOrFail($id);
        $video->name = $request->input('name');

        if($request->hasfile('thumbnail')){
            /* Remove old image */
            $thumbnail = basename($video->thumbnail);
            $thumbnailUrl = '/vr/thumbnails/'.$thumbnail;
            Storage::disk('s3')->delete($thumbnailUrl);

            $file=$request->file('thumbnail');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $filename=$file->hashName();
            $path1 = 'vr/thumbnails/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);

            $video->thumbnail=$path;
        };

        $video->update();

        return redirect('admin/video')->with('success','You have successfully updated data.');

    }

    // public function download(Request $request, $id) {
    //     try {
    //         $videoDetail = Video::where('id', $id)->first();
    //         $fileName = $videoDetail->url;
    //         $tmp = explode('/', $fileName);
    //         $lastElement = end($tmp);

    //         //p($lastElement); die;

    //         // Get real path for our folder
    //         $rootPath = realpath("vr");

    //         // Initialize archive object
    //         $zip = new ZipArchive();
    //         $zip->open("$lastElement", ZipArchive::CREATE | ZipArchive::OVERWRITE);

    //         // Initialize empty "delete list"
    //         $filesToDelete = array();

    //         // Create recursive directory iterator
    //         /** @var SplFileInfo[] $files */
    //         $files = new RecursiveIteratorIterator(
    //             new RecursiveDirectoryIterator($rootPath),
    //             RecursiveIteratorIterator::LEAVES_ONLY
    //         );

    //         foreach ($files as $name => $file)
    //         {
    //             // Skip directories (they would be added automatically)
    //             if (!$file->isDir())
    //             {
    //                 // Get real and relative path for current file
    //                 $filePath = $file->getRealPath();
    //                 $relativePath = substr($filePath, strlen($rootPath) + 1);

    //                 // Add current file to archive
    //                 $zip->addFile($filePath, $relativePath);

    //                 // Add current file to "delete list"
    //                 // delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
    //                 if ($file->getFilename() != 'important.txt')
    //                 {
    //                     $filesToDelete[] = $filePath;
    //                 }
    //             }
    //         }

    //         $zipName = $zip->filename;

    //         // Zip archive will be created only after closing object
    //         $zip->close();

    //         // Delete all files from "delete list"
    //         foreach ($filesToDelete as $file)
    //         {
    //             @unlink($file);
    //         }

    //         return response()->download("$zipName");
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }
}

