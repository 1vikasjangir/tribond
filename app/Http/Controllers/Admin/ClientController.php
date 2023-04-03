<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Storage;
use Image;

class ClientController extends Controller
{
    public function index(Request $request){
        $clients = Client::query();

        if (isset($request->title) && $request->title != '') {
            $title = $request->title;
            $clients->where('company_name','LIKE','%'.$title.'%');
        }

        if(isset($request->created_date) && $request->created_date != ''){
            $created_date = $request->created_date;
            $clients->where('created_at','LIKE','%'.$created_date.'%');
        }

        if (isset($request->status) && $request->status != '') {
            $status = $request->status;
            $clients->where('status', $status);
        }

        $clients = $clients->orderBy('updated_at', 'DESC')->paginate(config('paginate.admin_paginate.page_count'));

        $data=compact('clients');
        return view('admin/client/index')->with($data);;
    }

    public function clientform(){
        return view('admin/client/add');
    }

    public function saveclient(Request $request){
       // print_r($request);
       $request->validate([
        'company_name'=>'required',
        'logo'=>'image|required'
       ]);
        $client=new Client();
        $client->company_name=$request['company_name'];

        if($request->hasfile('logo')){
            $file=$request->file('logo');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $filename=$file->hashName();
            $path1 = 'clients/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);
            $client->logo=$path;
        };

        $client->status="1";

        $last_client=Client::orderBy('id','desc')->first();
        if(!$last_client){
            $last_client=1;
            $client->sort_order=$last_client;
        }
        else{
            $client->sort_order=$last_client->sort_order+1;
        }

        $client->save();
        return redirect('admin/client')->with('success','You have successfully added data.');
    }


    public function delete(Request $request){
        $client=Client::findOrFail($request->client_id);

        if(!is_null( $client))
        {
            /* Remove old image */
            $image = basename($client->logo);
            $image_path = '/clients/'.$image;
            Storage::disk('s3')->delete($image_path);

            $client->delete();
        }

        return response()->json([
            'status' => true,
            'success' => "You have successfully deleted!",
        ]);
        // return redirect()->back()->with('success', "You have successfully deleted!");
    }

    public function edit($id){
        $client=Client::findOrFail($id);

        if(is_null($client)){
            return redirect()->back();
        }else{
            $updateurl=url('/update-data')."/".$id;
            return view('admin/client/edit',compact('client'));
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'company_name'=>'required',
            // 'logo'=>'image|required'
           ]);

        $client=Client::findOrFail($id);
        $client->company_name=$request->input('company_name');
        if($request->hasfile('logo')){
            /* Remove old image */
            $image = basename($client->logo);
            $image_path = '/clients/'.$image;
            Storage::disk('s3')->delete($image_path);

            $file=$request->file('logo');
            $img = Image::make($file->getRealPath());
            $img->orientate();
            $filename=$file->hashName();
            $path1 = 'clients/'.$filename;
            $path = Storage::disk('s3')->put($path1, $img->stream()->__toString(), 'public');
            $path = Storage::disk('s3')->url($path1);
            $client->logo=$path;
        };
        $client->update();
        return redirect('admin/client')->with('success','You have successfully updated data.');
    }

    public function clientstatus(Request $request){
        $clientsStatus=client::findOrFail($request->client_id);
        $clientsStatus->status = !$clientsStatus->status;
        $clientsStatus->update();
        return response()->json([
            'status' => $clientsStatus->status,
            'success' => "You have successfully changed status.",
        ]);
        // return redirect()->back()->with('success','You have successfully changed status.');
    }

}
