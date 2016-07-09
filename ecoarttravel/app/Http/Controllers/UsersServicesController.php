<?php namespace App\Http\Controllers;


use App\Libraries\Repositories\UserServicesRepository;
use App\User;
use Illuminate\Http\Request;

class UsersServicesController extends Controller {

    public function __construct(UserServicesRepository $userServicesRepository){
        $this->userServicesRepository = $userServicesRepository;
    }

    public function getGuides(){
        $guides = $this->userServicesRepository->getGuides();
        return response()->json($guides);
    }

    public function getGuidesByLanguage(Request $request){
        $languageIds = $request->input("language_ids");

        $guides = $this->userServicesRepository->getGuidesByLanguages($languageIds);

        return response()->json($guides);
    }
} 