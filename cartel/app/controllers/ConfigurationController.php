<?php
class ConfigurationController extends BaseController {
  
	/** -----------------------------------------------------------------------
	*  setMinimumBrokerage(): sets the minimum brokerage fees that must
  *                         be paid by the company.
	*
	* @param  int  $id
	* @return Response
	-------------------------------------------------------------------------*/
  public function setMinimumBrokerage(){
    /* Get the input */
    $day_30  = Input::get('30_day', '');
    $day_365  = Input::get('365_day', '');

    /* Validate the input */
    $validator_data = array('30_day' => $day_30, '365_day' => $day_365);
    $validator_rules = array('30_day' => 'required|integer|min:1', 
                              '365_day'=> 'required|integer|min:1');
    $validator = Validator::make($validator_data, $validator_rules);
    if($validator->fails()) 	
      return Redirect::back()->withErrors($validator)->withInput();		

    /* Store the input */
    $configuration_day_30 = Configuration::firstOrNew(array('cname' => 'brokerage_30day_min'));
    $configuration_day_30->cvalue = $day_30;
    $configuration_day_30->save();
    $configuration_day_365 = Configuration::firstOrNew(array('cname' => 'brokerage_365day_min'));
    $configuration_day_365->cvalue = $day_365;
    $configuration_day_365->save();
    
    return Redirect::back()->with('messages', 
                    array(Lang::get('site_content_admin.global_admin_Successful_Save'),
                    $this->pageData['success']));
  }
} // class
?>
