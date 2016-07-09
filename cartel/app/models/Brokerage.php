<?php
class Brokerage extends Eloquent {
	protected $table = 'brokerage';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * lookupBrokerage():
	 *                     Get the brokerage details of one brokerage row
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function lookupBrokerage($brokerage_id) {
		//$brokerageInfo = DB::table('brokerage')->where('id', '=', $brokerage_id );
		$brokerageInfo = DB::select(DB::raw("
			SELECT b.id, b.name, b.type, b.rate, b.brokerage_group_id, b.display FROM brokerage b
			WHERE b.id = :brokerage_id
			"), 
			array(
			'brokerage_id' => $brokerage_id,
		));		
 
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($brokerageInfo))
        throw new ModelNotFoundException("lookupBrokerage(): \$brokerageInfo not found");
    return $brokerageInfo[0];
	}
	
	
 /**-------------------------------------------------------------------------
  * lookupBorkerageOptions():
	*            Get the brokerage details, based on date of transactions and
  *            brokerage type
  *--------------------------------------------------------------------------
  *
  *-------------------------------------------------------------------------*/ 
	public static function lookupBrokerageOptions($locale_id, $language_id, $brokerage_group_id, $order_date) {
		$brokerageInfo = DB::select(DB::raw("
			SELECT b.id, b.name, b.type, b.rate, b.brokerage_group_id FROM brokerage b
			WHERE b.locale_id = :locale_id AND b.language_id = :language_id AND brokerage_group_id = :brokerage_group_id AND :order_date BETWEEN b.start_date AND b.end_date
			"), 
			array(
			'locale_id' => $locale_id,
			'language_id' => $language_id,
			'brokerage_group_id' => $brokerage_group_id,
			'order_date' => $order_date,
		));
    if(empty($brokerageInfo))
      return array();
		return $brokerageInfo;
	} // lookupBorkerageOptions()


  /**-------------------------------------------------------------------------
  * calcBrokerage(): 
  *                 
  *--------------------------------------------------------------------------
  *
  *-------------------------------------------------------------------------*/
	public static function calcBrokerage($brokerageInfo, $qty, $price) {
    
		/*  we need to use the highest of Base, PerItem or Percent  */
		foreach ($brokerageInfo as $key => &$value) {	
      /*  Calc the different brokerage amount options  */
			if($value->type == 'base')
				$value->amount = $value->rate;
			elseif($value->type == 'dollar')
				$value->amount = $value->rate * $qty;
			elseif($value->type == 'percent')
				$value->amount = round($value->rate,2) * ($qty * $price) ;
		}
    
		/*  Now get the highest of the different amounts  */
		$brokerage_amount = 0;
    $brokerage_id = 0;
    
		foreach ($brokerageInfo as $key => $value) {	
      if($value->amount >= $brokerage_amount) {	
        $brokerage_amount = $value->amount;
				$brokerage_id = $value->id;
			}
		}	
    
		return array('brokerage_amount' => $brokerage_amount, 'brokerage_id' => $brokerage_id);
	} // calcBrokerage()
} // class
?>
