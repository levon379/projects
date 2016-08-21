<?php namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Intervention\Image\Facades\Image;
use Validator;

class ProvidersController extends Controller {

    public function __construct(Request $request, Guard $auth){
        $this->request = $request;
        $this->auth = $auth;
    }

    public function index(){
		$mode = 'add';
        $providers = Provider::orderBy("id", "DESC")->paginate(10);
        $newImage = true;
        return view('providers.index',compact('providers', 'mode','newImage'));
    }

    public function add(){
        $mode = 'add';
        return view('providers.index',compact('mode'));
    }

    public function postAdd(){
        $name = Input::get('name');
        $photo = $this->request->file('photo');
        $contactInfo = Input::get('contact_info');

        $provider = new Provider;
        $provider->name = $name;
        $provider->contact_info = $contactInfo;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );

        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $provider->save();

            if($provider->id){

                $path = storage_path()."/uploads/providers/".$provider->id;

                if (!is_dir($path)) {
                    mkdir($path,0755,true);
                }

                if(!empty($photo)){
                    $extension = $photo->getClientOriginalExtension();
                    $file_name = "provider.$extension";
                    $mime_type = $photo->getClientMimeType();

                    Image::make($photo->getPathname())->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path/$file_name");


                    $provider->image_extension = $extension;
                    $provider->image_mime_type = $mime_type;

                    $provider->save();

                }

                return redirect("/admin/providers/")
                    ->with('success','Provider successfully added');
            }
        }

        return redirect("/admin/providers/")->withInput()->withErrors($validation);

    }

    public function edit($id){
        $provider = Provider::find($id);
		$providers = Provider::orderBy("id", "DESC")->paginate(10);
        $mode = 'edit';
        $newImage = true;
        if( $provider->image_extension != null){
            $newImage = false;
        }
        return view('providers.index',compact('provider', 'providers', 'mode', 'newImage'));
    }

    public function postEdit($id){

        $name = Input::get('name');
        $photo = $this->request->file('photo');
        $contactInfo = Input::get('contact_info');

        $provider = Provider::find($id);
        $provider->name = $name;
        $provider->contact_info = $contactInfo;

        $input = Input::all();

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => 'This name field is required'
        );


        $validation = Validator::make($input, $rules,$messages);

        if($validation->passes()){


            $provider->save();

            if($provider->id){

                $path = storage_path()."/uploads/providers/".$provider->id;

                if (!is_dir($path)) {
                    mkdir($path,0755,true);
                }

                if(!empty($photo)){
                    $extension = $photo->getClientOriginalExtension();
                    $file_name = "provider.$extension";
                    $mime_type = $photo->getClientMimeType();

                    Image::make($photo->getPathname())->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save("$path/$file_name");


                    $provider->image_extension = $extension;
                    $provider->image_mime_type = $mime_type;

                    $provider->save();

                }

                return redirect("/admin/providers/")
                    ->with('success','Provider successfully updated');
            }
        }

        return redirect("/admin/providers/")->withInput()->withErrors($validation);
    }

    public function delete($id){
        $provider = Provider::find($id);
        $name = $provider->name;

        try {
            $provider->delete();
        } catch (QueryException $e) {
            return redirect('/admin/addons')->with("error","<b>$name</b> cannot be deleted it is being used by a product");
        }

        return redirect('/admin/providers')->with("success","<b>$name</b> has been deleted successfully");

    }
}