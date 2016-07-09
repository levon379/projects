<?php
class HelpButtonController extends BaseController {

  /**-------------------------------------------------------------------------
  * getHelp():
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
	public static function getHelp($viewname) {
    $help['helpTitle'] = Lang::get('help_content.'.$viewname.'-title'); 
    $help['helpMessage'] = Lang::get('help_content.'.$viewname.'-content'); 
    return $help;
	} // getHelp()
  
  /**-------------------------------------------------------------------------
  * getHelp(): Checks if a view has a help message 
  *                 
  * @return Response
  *-------------------------------------------------------------------------*/
  public static function hasHelp($viewname) {
   $has =  (Lang::has('help_content.'.$viewname.'-title') &&
            Lang::has('help_content.'.$viewname.'-content'));
   return $has;
  } // hasHelp()
 } //class
?>
