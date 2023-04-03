<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //
    public function index(Request $request) {

        $projects = Project::where('status', '1')->orderBy("sort_order")->paginate(8);
        if($request->ajax()){
            $projectArr = json_decode(json_encode($projects), true);
            foreach($projects as $key => $project){
                $projectArr['data'][$key]['media'] = json_decode(json_encode($project->getProjectMedia), true);
            }
            return json_encode($projectArr);
        }else{
            return view('frontend.projects', compact('projects'));
        }

    }
}
