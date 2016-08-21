<?php

namespace App\Http\Controllers\Backend;

use App\Models\StaticPages;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class StaticPageController extends Controller {    
    
    public function index()
    {
        $static_pages = StaticPages::all();
        return view('backend.admin.CMS.pages.index',['static_pages'=>$static_pages]);
    }

    public function create()
    {
        
        return view('backend.admin.CMS.pages.create');
    }
    public function store(Request $request)
    {
        $method = $request->method();
        if ($method == 'POST') 
        {
            $input = Input::all();
            $model = new StaticPages;
            $model->title = $input['title'];
            $model->content = $input['content'];
            $status = 0;
            if(isset($input['status'])){
                $status = 1;
            }
            $model->status = $status;
            $model->created_by = time();
            $model->updated_by = time();
           if($model->save()){
                return Redirect::to('admin/pages/');
            }else{
                return Redirect::to('admin/pages/store');
            }
        }
    }


    public function edit($id)
    {
        $static_page = StaticPages::find($id);
        return view('backend.admin.CMS.pages.edit',['static_page'=>$static_page]);
    }

    public function update(Request $request,$id)
    {
        
        $method = $request->method();
        if ($method == 'POST') 
        {
            $input = Input::all();
            $model = StaticPages::find($id);
            $model->title = $input['title'];
            $model->content = $input['content'];
            $status = 0;
            if(isset($input['status'])){
                $status = 1;
            }
            $model->status = $status;
            $model->updated_by = time();
            if($model->save()){
                return Redirect::to('admin/pages/');
            }else{
                return Redirect::to('admin/pages/edit/'.$id);
            }
        }
        
    }
    
    public function delete($id) 
    {
        $model = StaticPages::find($id);
        $model->delete();
        return Redirect::to('admin/blog/');
    }

}
