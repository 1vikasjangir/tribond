<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request ){
        return view('login');

    }
    public function register(Request $request ){
        return view('register');
    }

}
