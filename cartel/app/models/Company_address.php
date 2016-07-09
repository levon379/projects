<?php
class Company_address extends Eloquent {
	protected $table = 'company_address';
	protected $guarded = ['id'];
	
  /**-------------------------------------------------------------------------
   * getOneShippingAddress():
   *                Lookup a SINGLE company shipping address                
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getOneShippingAddress($address_id) {
		$address = DB::select( DB::raw("select ca.*, p.code as province_code, p.name as province_name, c.code as country_code, c.name as country_name, status.name as status_name, status.color as status_color from company_address ca
			INNER JOIN province p ON ca.province_id = p.id
			INNER JOIN country c ON ca.country_id = c.id
			LEFT JOIN status ON ca.status_id = status.id
			WHERE ca.id = :address_id
			"), array('address_id' => $address_id,));
    
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($address))
      throw new ModelNotFoundException("getOneShippingAddress(): \$address not found");
      
		/* Check if the address exists, if not, then it's for pickup/delivery */
    return $address[0];  // collapse the array one level, don't need the extra [0] dimension
	}

	 
  /**-------------------------------------------------------------------------
   * getShipRcvAddresses:
   *                  Lookup company shipping or receiving addresses
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getShipRcvAddresses($locale_id, $language_id, $company_id, $address_type, $active = 50) {
		$addresses = DB::select( DB::raw("select ca.*, p.code as pname, c.code as cname from company_address ca
			INNER JOIN province p ON ca.province_id = p.id
			INNER JOIN country c ON ca.country_id = c.id
			WHERE ca.locale_id = :locale_id AND ca.language_id = :language_id AND ca.status_id = :status_id AND ca.company_id = :company_id AND ca.ship_or_recv IN (:address_type,'Both')
			ORDER BY ca.address
			"), 
      array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'status_id' => $active,
            'company_id' => $company_id,
            'address_type' => $address_type,
          )
    );
    if(empty($addresses))
      return array();
      
		return $addresses;
	}

  /**-------------------------------------------------------------------------
   * getItems():
   *                 
   *--------------------------------------------------------------------------
   *
   *-------------------------------------------------------------------------*/
	public static function getItems($locale_id, $language_id, $company_id) {
		$items = DB::select(DB::raw("
			SELECT ca.id FROM company_address ca
			WHERE ca.locale_id = :locale_id AND ca.language_id = :language_id AND ca.company_id = :company_id AND ca.status_id IN (50,51)
			ORDER BY ca.company, ca.address
			"), 
			array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
            'company_id' => $company_id,
           )
    );
    if(empty($items))
      return array();
		return $items;
	}
}
?>
