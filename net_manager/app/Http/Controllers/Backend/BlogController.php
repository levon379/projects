<?php

namespace App\Http\Controllers\Backend;

use App\Models\Blog;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller {

    public function index() {
        $blog_article = Blog::all();
        return view('backend.admin.CMS.blog.index', ['blog_article' => $blog_article]);
    }

    public function create() {

        return view('backend.admin.CMS.blog.create');
    }

    public function store(Request $request) {
        $method = $request->method();
        if ($method == 'POST') {
            $input = Input::all();
            $model = new Blog;
            $model->title = $input['title'];
            $model->content = $input['content'];
            $model->author = $input['content'];
            $model->tags = $input['tags'];
            $model->category = $input['category'];
            $status = 0;
            if (isset($input['status'])) {
                $status = 1;
            }
            $model->status = $status;
            $model->created_by = time();
            $model->updated_by = time();
            $file = array('image' => Input::file('image'));
            $destinationPath = './uploads/blog';
            $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
            $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
            Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
            $path = '/uploads/blog/' . $fileName;
            $model->featured_image = $path;
            if ($model->save()) {
                return Redirect::to('admin/blog/');
            } else {
                return Redirect::to('admin/blog/store');
            }
        }
    }

    public function edit($id) {
        $blog_article = Blog::find($id);
        return view('backend.admin.CMS.blog.edit', ['blog_article' => $blog_article]);
    }

    public function update(Request $request, $id) {
        $method = $request->method();
        if ($method == 'POST') {
            $input = Input::all();
            $model = Blog::find($id);
            $model->title = $input['title'];
            $model->content = $input['content'];
            $model->author = $input['content'];
            $model->tags = $input['tags'];
            $model->category = $input['category'];
            $status = 0;
            if (isset($input['status'])) {
                $status = 1;
            }
            $model->status = $status;
            $model->created_by = time();
            $model->updated_by = time();
            if(Input::file('image')){
                $file = array('image' => Input::file('image'));
                $destinationPath = './uploads/blog';
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                $path = '/uploads/blog/' . $fileName;
                $model->featured_image = $path;
            }
            if ($model->save()) {
                return Redirect::to('admin/blog/');
            } else {
                return Redirect::to('admin/blog/store');
            }
        }
    }

    public function delete($id) {
        $model = Blog::find($id);
        $model->delete();
        return Redirect::to('admin/blog/');
    }

}
