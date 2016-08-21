<?php
/**
 * Created by PhpStorm.
 * User: Aivan
 * Date: 3/10/2016
 * Time: 2:49 AM
 */

namespace App\Libraries\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;


class UserServicesRepository {

    public function getGuides(){
        $users = User::where('user_type_id',3)->get();

        $guides = [];

        foreach($users as $user){
            $guides[] = array(
                'id' => $user->id,
                'text' => $user->getName()
            );
        }

        return $guides;
    }

    public function getGuidesByLanguages($languageIds){
        $query = "SELECT u.id,
                       u.firstname,
                       u.lastname,
                       IFNULL(lm.language_match, false) AS language_match
                FROM   users u
                       LEFT JOIN (SELECT u.id,
                                         u.firstname,
                                         u.lastname,
                                         true AS language_match
                                  FROM   users_languages ug
                                         JOIN users u
                                           ON u.id = ug.user_id
                                         JOIN languages l
                                           ON l.id = ug.language_id
                                  WHERE  u.user_type_id = 3
                                         AND ug.language_id IN ($languageIds)
                                  GROUP  BY u.id) AS lm
                              ON lm.id = u.id
                WHERE  u.user_type_id = 3
                ORDER  BY lm.language_match DESC, u.firstname ASC ";

        $result = DB::select($query);

        $guides = [];

        foreach($result as $guide){
            $guides[] = array(
                'id' => $guide->id,
                'text' => $guide->firstname .' '.$guide->lastname,
                'match' => $guide->language_match
            );
        }

        return $guides;
    }
}