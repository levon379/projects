<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.users.index');
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(UserRequest $request)
    {

    }
    
    public function edit()
    {
        return view('backend.users.edit');
    }

    public function update(User $user)
    {

    }

}
