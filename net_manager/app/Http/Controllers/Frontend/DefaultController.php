<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class DefaultController extends Controller
{
    public function dashboardAdmin()
    {
        return view('backend.admin.general.dashboard');
    }

    public function index (){
        return view ('frontend.pages.index');
    }

    public function contact (){
        return view ('frontend.pages.contact');
    }

    public function contactMailSend (){

    }
}
