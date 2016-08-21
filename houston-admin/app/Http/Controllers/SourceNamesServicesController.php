<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SourceName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SourceNamesServicesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getSourceNamesBySourceGroupId(){
        $id = Input::get('source_group_id');
        $sourceNames = SourceName::where('source_group_id','=',$id)->get();
        $sources = [];
        foreach($sourceNames as $sn){
            $sources[] = array(
                'id' => $sn['id'],
                'text' => $sn['name'],
            );
        }
        return response()->json($sources);
    }
}
