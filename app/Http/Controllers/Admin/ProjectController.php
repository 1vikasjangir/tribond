<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::query();

        if (isset($request->title) && $request->title != '') {
            $title = $request->title;
            $projects->where('title','LIKE','%'.$title.'%');
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $projects->where('created_at','LIKE','%'.$created_date.'%');
        }

        if (isset($request->status) && $request->status != '') {
            $status = $request->status;
            $projects->where('status', $status);
        }

        $projects = $projects->orderBy('sort_order', 'ASC')->paginate(config('paginate.admin_paginate.page_count'));

        return view('admin.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.project.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'hash_tags'=>'required',
            'thumbnail'=>'image|required',
            'main_image'=>'image|required'
        ]);

        try{
            $project = new Project();
            $project->title = $request->title;
            $project->description = $request->description;

            if($request->hasfile('thumbnail')){
                $file=$request->file('thumbnail');
                $img = Image::make($file->getRealPath());
                $img->orientate();
                $img->fit(812, 536, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $filename=$file->hashName();
                $thumbnailPath = 'projects/thumbnails/'.$filename;
                $path = Storage::disk('s3')->put($thumbnailPath, $img->stream()->__toString(), 'public');
                $path = Storage::disk('s3')->url($thumbnailPath);
                $project->thumbnail=$path;
            };

            if($request->hasfile('main_image')){
                $file=$request->file('main_image');
                $img = Image::make($file->getRealPath());
                $img->orientate();
                $img->fit(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $filename=$file->hashName();
                $path1 = 'projects/main_image/'.$filename;
                $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
                $path = Storage::disk('s3')->url($path1);
                $project->main_image=$path;
            };

            $project->hash_tags = $request->hash_tags;
            if($request->fullwidth_image == 'on') {
                $fullwidth_image = '1';
            } else {
                $fullwidth_image = '0';
            }
            
            $project->fullwidth_image = $fullwidth_image;
            $project->status = "1";

            $last_project = Project::max('sort_order');

            if(!$last_project){
                $last_project=1;
                $project->sort_order=$last_project;
            }
            else{
                $project->sort_order=$last_project+1;
            }

            $project->save();

            return redirect()->route('projects.index')->with('success','Project added successfully');
        }catch(Exception $e){
            //dd($e);
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('admin.project.edit', compact('project'));
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
            'title'=>'required',
            'description'=>'required',
            'hash_tags'=>'required',
            // 'thumbnail'=>'image|required',
            // 'main_image'=>'image|required'
        ]);

        $project=Project::findOrFail($id);
        $project->title=$request->input('title');
        $project->description=$request->input('description');

        if($request->hasfile('thumbnail')){
            /* Remove old image */
            $thumbnail = basename($project->thumbnail);
            $thumbnailUrl = '/projects/thumbnails/'.$thumbnail;
            Storage::disk('s3')->delete($thumbnailUrl);

            $file=$request->file('thumbnail');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $img->resize(null, 625, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename=$file->hashName();
            $thumbnailPath = 'projects/thumbnails/'.$filename;
            $path = Storage::disk('s3')->put($thumbnailPath, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($thumbnailPath);

            $project->thumbnail=$path;
        };

        if($request->hasfile('main_image')){
            /* Remove old image */
            $mainImage = basename($project->main_image);
            $mainImageUrl = '/projects/main_image/'.$mainImage;
            Storage::disk('s3')->delete($mainImageUrl);

            $file=$request->file('main_image');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $img->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename=$file->hashName();
            $path1 = 'projects/main_image/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);
            $project->main_image=$path;
        };

        $project->hash_tags = $request->input('hash_tags');

        if($request->fullwidth_image == 'on') {
            $fullwidth_image = '1';
        } else {
            $fullwidth_image = '0';
        }
        $project->fullwidth_image = $fullwidth_image;

        $project->update();

        return redirect('admin/projects')->with('success','You have successfully updated data.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project=Project::findOrFail($request->project_id);
        if(!is_null($project))
        {
            $thumbnail = basename($project->thumbnail);
            $thumbnailUrl = '/projects/thumbnails/'.$thumbnail;
            Storage::disk('s3')->delete($thumbnailUrl);

            $mainImage = basename($project->main_image);
            $mainImageUrl = '/projects/main_image/'.$mainImage;
            Storage::disk('s3')->delete($mainImageUrl);

            $project->delete();
        }
        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);
        // return redirect()->back()->with('success', "You have successfully deleted!");
    }

    public function statusProject(Request $request){
        $statusOfProject = Project::findOrFail($request->project_id);
        // p($statusOfProject->status);
        $statusOfProject->status = (int)!$statusOfProject->status;
        // p($statusOfProject->status); die;
        $statusOfProject->update(['status'=> (string)$statusOfProject->status]);
        return response()->json([
            'status' => $statusOfProject->status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success','You have successfully changed status.');
    }

    public function changeOrder(Request $request, $id){
        $projectDetail=Project::findOrFail($id);
        $projectDetailOrderValue = $projectDetail->sort_order;
        // p($projectDetailOrderValue);

        $previousProjectDetail=Project::where('sort_order', ($projectDetail->sort_order-1))->first();
        $previousProjectDetailOrderValue = $previousProjectDetail->sort_order;
        // p($previousProjectDetailOrderValue); die;

        // get previous projectDetail id
        $previous = Project::where('id', '<', $projectDetail->id)->max('id');

        // p($previous);die;

        if ($previous) {
            $projectDetail->update(['sort_order'=>$previousProjectDetailOrderValue]);
            $previousProjectDetail->update(['sort_order'=>$projectDetailOrderValue]);
        }

        return redirect()->back()->with('success','You have successfully changed status.');
    }

    public function changePreviousOrder(Request $request){
        $projectDetail=Project::findOrFail($request->id);
        $projectDetailOrderValue = $projectDetail->sort_order;
        // p($projectDetailOrderValue);
        // $next = Project::where('id', '>', $projectDetail->id)->min('id');
        // $previous = Project::where('id', '<', $projectDetail->id)->max('id');

        if ($request->atype == "down") {
            $nextProjectDetail=Project::findOrFail($request->next_project_id);
            $nextProjectDetailOrderValue = $nextProjectDetail->sort_order;
            // $next = Project::where('id', '>', $projectDetail->id)->min('id');
            // if ($next) {
                $projectDetail->update(['sort_order'=>$nextProjectDetailOrderValue]);
                $nextProjectDetail->update(['sort_order'=>$projectDetailOrderValue]);
            // }
        } else {
            $previousProjectDetail=Project::findOrFail($request->previous_project_id);
            $previousProjectDetailOrderValue = $previousProjectDetail->sort_order;
            // $previous = Project::where('id', '<', $projectDetail->id)->max('id');
            // if ($previous) {
                $projectDetail->update(['sort_order'=>$previousProjectDetailOrderValue]);
                $previousProjectDetail->update(['sort_order'=>$projectDetailOrderValue]);
            // }
        }

        return response()->json([
            'status' => true
        ]);

        // return redirect()->back()->with('success','You have successfully changed status.');
    }
}
