<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Video;
use App\Models\SupportQuery;
use App\Mail\SendMail;
use Mail;

class HomeController extends Controller
{
    public function index()
    {
        return view('../frontend/coming_soon');

        /**** Get client ***/
        $clients = Client::all();
        $videoTours = Video::where("status", 1)->orderBy("id")->get();
        return view('../frontend/index', compact('clients', 'videoTours'));
    }

    public function home()
    {
        $videoTours = [];
        session(['contact_hidden_csrf' => rand(1000, 9999)]);
        return view('../frontend/index', compact('videoTours'));
    }

    public function instagramFeed()
    {
        $instagramContent = getInstagram();
        return view('../frontend/section/instagram', compact( 'instagramContent'));
    }

    public function virtualTours()
    {
        $videoTours = Video::where("status", 1)->orderBy("id")->get();
        return view('../components/frontend/tour', compact('videoTours'));
    }

    public function sendEmail(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|integer',
            'message' => 'required',
            'captcha' => 'required|captcha'
        ]);
        
        $clientIP = request()->ip();
        $request->message = cleaner($request->message);
        $request->name = cleaner($request->name);
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
            'captcha' => $request->captcha,
            'randomCode' => $request->csrfHidden,
            'ip' => $clientIP,
        );
        
        $checkOldRequest = SupportQuery::where("ip", $clientIP)
                           ->whereDate("created_at", date("Y-m-d"))
                           ->count();
        if($request->session()->get('contact_hidden_csrf') == $request->csrfHidden && $checkOldRequest == 0){
            $support=new SupportQuery();
            $support->name= $request->name;
            $support->email= $request->email;
            $support->mobile= $request->mobile;
            $support->message= $request->message;
            $support->randomCode= $request->csrfHidden;
            $support->ip= $clientIP;
            $support->save();
            Mail::to('jack@riskassessor.net', 'Bruce Way')->send(new SendMail($data));
            $_SESSION['contact_hidden_csrf'] = rand(1000, 9999);
        }

        if($request->ajax()){
            return response()->json(['success' => 'Thanks for reaching out. We’ve received your message and will be back in touch ASAP'], 200);
        }
    }

    public function pointOfSale()
    {
        session(['contact_hidden_csrf' => rand(1000, 9999)]);
        $videoTours = Video::where("status", 1)->orderBy("id")->get();
        return view('../frontend/pos', compact('videoTours'));
    }

    public function privacy()
    {
        return view('../frontend/privacy');
    }

    public function teamImages()
    {
        $teamArr = array();
        $teamArr[0] = 'James-b';
        $teamArr[1] = 'Mike-b';
        $teamArr[2] = 'Mark-b';
        $teamArr[3] = 'Kay-b';
        $teamArr[4] = 'dave-b';
        $teamArr[5] = 'Charles-b';
        $teamArr[6] = 'Mat-b';
        echo json_encode($teamArr);exit;
    }

    public function sustainability()
    {
        return view('../frontend/sustainability');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
