<?php
class Tax extends Eloquent {
	protected $table = 'tax';
	protected $fillable = [];

  /**-------------------------------------------------------------------------
   * lookupTaxes():
   *                 
	 *  get the taxes that apply, based on date of transactions 
   *--------------------------------------------------------------------------
   *
   * @param  int  $id
   * @return Response
   *-------------------------------------------------------------------------*/
	public static function lookupTaxes($locale_id, $language_id, $tax_group_id, $order_date) {
		$taxInfo = DB::select(DB::raw("
			SELECT t.name, t.rate, (t.rate/100) as rate_decimal, tax_product, tax_brokerage FROM tax t
			LEFT JOIN tax_group tg ON t.tax_group_id = tg.id
			WHERE t.locale_id = :locale_id AND t.language_id = :language_id AND tax_group_id = :tax_group_id AND :order_date BETWEEN start_date AND end_date"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'tax_group_id' => $tax_group_id,
            'order_date' => $order_date,
      )
    );
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($taxInfo))
        throw new ModelNotFoundException("lookupTaxes(): \$taxInfo is empty");
    return $taxInfo[0];
	}
}
?>
