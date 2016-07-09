<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'piwik_user';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    public static function listAllpiwik_user() {
        return DB::table('piwik_user')->select('email')->get();
    }

    public static function listAllUsers() {
        return DB::table('piwik_user')
                ->leftJoin('piwik_site', 'piwik_site.user_id', '=', 'piwik_user.id')
                ->select('piwik_user.*', 'piwik_site.main_url')
                ->where('piwik_user.superuser_access','!=',1)
                ->orderBy('piwik_user.id', 'asc')
                ->orderBy('piwik_site.idsite', 'asc')
                ->groupBy('piwik_user.id')
                ->get();
    }

    public static function searchAdmin($userdata = array()) {
        if (!empty($userdata)){
            return DB::table('piwik_user')->where('email', $userdata['email'])->get();
        }else {
            return DB::table('piwik_user')->where('superuser_access', '=', 1)->get();
        }
    }

    public static function registerUser($data) {
        return DB::table('piwik_user')->insert($data);
    }

    public static function creatNewPassword($data) {
        $password = $data['newpassword'];
        $query = DB::table('piwik_user')->where('id', '=', $data['user_id'])->update(array('password' => $password));
        return $query;
    }

    public static function recoverPassword($code) {
        $query = DB::table('piwik_user')->where('code', '=', $code)->where('password_temp', '!=', '');
        return $query->first();
    }

    public static function changeAccountSettings($data) {
        return DB::table('piwik_user')->where('id', Auth::user()->id)->update($data);
    }

    public static function findUserByEmail($data) {
        return DB::table('users')->where('email', $data['email'])->first();
    }

    public static function getUserEmail($user_id) {
        return DB::table('piwik_user')->where('id', $user_id)->first();
    }

    public static function getAccountByID($id) {
        return DB::table('piwik_user')->where('id', $id)->first();
    }

    public static function deleteUser($id) {
        return DB::table('piwik_user')->where('id', $id)->delete();
    }

}
