<?php
class Company extends Eloquent {
  protected $table = 'company';
  protected $fillable = [];

  /**-------------------------------------------------------------------------
    * getNestedItems():
    *                 
    *--------------------------------------------------------------------------
    *
    *-------------------------------------------------------------------------*/
  public static function getNestedItems($locale_id, $language_id, $parent_id = 0) {
    $items = DB::select(DB::raw("
      SELECT c.id FROM company c
      WHERE c.locale_id=:locale_id AND c.language_id=:language_id AND c.status_id IN (13,14)
      ORDER BY c.name"),
      array(
            'locale_id' => $locale_id,
            'language_id' => $language_id,
        )
      );
      if(empty($items))
        return array();

      foreach ($items as $key => $value) {
        $items[$key]->sub = array();
        $items[$key]->sub = User::getNestedItems($value->id);
      }
      return $items;
  }

  /**-------------------------------------------------------------------------
    * getCompanyInfo():
    *                 
    *--------------------------------------------------------------------------
    *
    *-------------------------------------------------------------------------*/
  public static function getCompanyInfo($company_id) {
    $companyInfo = DB::select(DB::raw("		
    select c.*, province.code as province_name, country.name as country_name, status.name as status_name, status.color as status_color FROM company c
    LEFT JOIN province ON c.province_id=province.id
    LEFT JOIN country ON c.country_id=country.id
    LEFT JOIN status ON c.status_id=status.id
    WHERE c.id=:company_id"), 
    array('company_id' => $company_id));
    
    /* Exceptions for empty queries where return is assumed to exist */
    if(empty($companyInfo))
      throw new ModelNotFoundException("getNestedItems(): \$company_info is empty");
      
    $companyInfo = $companyInfo[0];  
    $companyInfo->sub = array();
    $companyInfo->credit_limit_exp = date("M j Y", strtotime($companyInfo->credit_limit_exp));
    $companyInfo->sub = array();
    $companyInfo->credit_limit_exp = date("M j Y", strtotime($companyInfo->credit_limit_exp));

    return $companyInfo;
  }
  
  
}
?>
