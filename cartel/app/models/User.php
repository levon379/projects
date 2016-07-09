<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
class User extends Eloquent implements UserInterface, RemindableInterface {
  use UserTrait,
      RemindableTrait;
  protected $table = 'user';
  protected $fillable = [];
  protected $hidden = array('remember_token');
  
  /**-------------------------------------------------------------------------
   * setAccessLevel():
   *                 
   * inbound "perm_groups" contains the user->perm_groups value of the current
   * logged in user, called from BaseController
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
  public static function setAccessLevel($perm_groups) { 
    
    /* Get the users Group permissions they'll inherit */
    $available_perms = Perm_group::whereRaw('id & ? AND status_id = 5', array($perm_groups))->get(array('name', 'moduleperms'));
    if(empty($available_perms))
      throw new ModelNotFoundException("setAccessLevel(): \$available_perms is empty");

    /* Do first one out of loop, since it baselines '$userperms' */
    $collection = $available_perms->shift();   // shift() pushes the first element into the var and off the array
    $userperms = (int) $collection->moduleperms;

    /* Iterate through the rest of the permissions */
    $available_perms->each(function($collection) use ($userperms) {
      /*   combine any permissions, giving the most lenient combination  */
      $userperms = (int) $userperms | (int) $collection->moduleperms;
    });

    
    $perm_module_names = Perm_module::whereRaw("lookupname != ''")->get(array('id', 'lookupname'));
    if(empty($perm_module_names))
      throw new ModelNotFoundException("setAccessLevel(): \$perm_module_names is empty");
    
    /* Establish the modules permission levels, and compare to users to set yes/no flags on each */
    $usermoduleperms = array();
    $perm_module_names->each(function($collection) use(&$usermoduleperms, $userperms) {
      $andresult = intval($collection->id) & intval($userperms);
      if ($andresult)
          $usermoduleperms[$collection->lookupname] = 1;
      else 
          $usermoduleperms[$collection->lookupname] = 0;
    });
    
    return $usermoduleperms;
  }

  /**-------------------------------------------------------------------------
   * getUserInfo():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
  public static function getUserInfo($user_id) {
    $userInfo = DB::select(DB::raw("		
      SELECT u.*, status.name AS status_name, status.color AS status_color
      FROM user u
      LEFT JOIN status 
      ON u.status_id = status.id
      WHERE u.id = :user_id"), 
      array('user_id' => $user_id));
    if(empty($userInfo))
      throw new ModelNotFoundException("getUserInfo(): \$userInfo is empty");
      
    $userInfo = $userInfo[0];
    $userInfo->companyInfo = Company::getCompanyInfo($userInfo->company_id);
    if(empty($userInfo->companyInfo))
      throw new ModelNotFoundException("getUserInfo(): \$companyInfo is empty");
    return $userInfo;
  }

  /**-------------------------------------------------------------------------
   * getNestedItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
  public static function getNestedItems($company_id = 0) {
  $items = DB::select(DB::raw("
    SELECT u.id FROM user u
    WHERE company_id = :company_id AND u.status_id IN (1,2)
    ORDER BY u.name"), array('company_id' => $company_id));
  
    if(empty($items))
      return array();
    return $items;
  }

  /**-------------------------------------------------------------------------
   * scopeUpdateLastOnlineTime():
   *           Stores the last time the user was online
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
  public function updateLastOnlineTime() {
    $this->last_online = new DateTime();
    $this->save();
  }
}
