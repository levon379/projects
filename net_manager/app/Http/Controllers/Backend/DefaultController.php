<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class DefaultController extends Controller
{
    public function dashboard()
    {
        return view('backend.dashboard');
    }

    public function showMedia ()
    {
        return view('backend.admin.CMS.media_library.show');
    }
}
