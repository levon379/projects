<?php

namespace App\Services;

use Illuminate\View\View;
use App\Models\Role;

class ViewComposer {

	// TODO: inject cache contract

    public function sidebar(View $view) 
    {
        $roles = Role::lists('name', 'code');
        $view->with(compact('roles'));
    }

}