<?php
class FormOptions extends Eloquent {

 /**-------------------------------------------------------------------------
  * getPostToFormOptions:
  *                 gets the options for the PostToController.
  *--------------------------------------------------------------------------
  *
  * @param  int  $id
  * @return Response
  *-------------------------------------------------------------------------*/ 
  public static function getAllFormOptions($locale_id, $language_id){
    $formOptions = array();
		$formOptions['placeOfOriginOptions'] = 
      FormOptions::getPlaceOfOriginOptions($locale_id, $language_id);
      
		$formOptions['provinceOptions'] =
      FormOptions::getProvinceOptions($locale_id, $language_id);
      
		$formOptions['productTypeOptions'] =
      FormOptions::getProductTypeOptions($locale_id, $language_id);
      
		$formOptions['productOptions'] =
      FormOptions::getProductOptions($locale_id, $language_id);
      
		$formOptions['varietyOptions'] =
      FormOptions::getVarietyOptions($locale_id, $language_id);
      
		$formOptions['bulkWeightTypeOptions'] =
      FormOptions::getBulkWeightTypeOptions($locale_id, $language_id);
      
		$formOptions['cartonWeightTypeOptions'] =
      FormOptions::getCartonWeightTypeOptions($locale_id, $language_id);
      
		$formOptions['bulkPackageOptions'] =
      FormOptions::getBulkPackageOptions($locale_id, $language_id);
      
		$formOptions['cartonPackageOptions'] =
      FormOptions::getCartonPackageOptions($locale_id, $language_id);
      
		$formOptions['maturityOptions'] =
      FormOptions::getMaturityOptions($locale_id, $language_id);
      
		$formOptions['colorsOptions'] =
      FormOptions::getColorsOptions($locale_id, $language_id);
      
		$formOptions['qualityOptions'] =
      FormOptions::getQualityOptions($locale_id, $language_id);
      
		$formOptions['otherProvinceOptions'] =
      FormOptions::getProvinceOptions($locale_id, $language_id);
      
		$formOptions['otherCountryOptions'] =
      FormOptions::getOtherCountryOptions($locale_id, $language_id);
    return $formOptions;
  }
  
  public static function getPlaceOfOriginOptions($locale_id, $language_id){
    return Origin::whereRaw("
      locale_id   = ? AND
      language_id = ? AND
      status_id   = ?",
      array($locale_id, $language_id, 35))
      ->orderBy('name')
      ->get(array('id', 'name'));
  }
    
  public static function getProvinceOptions($locale_id, $language_id){
    return Province::whereRaw("
      locale_id = ? AND
      language_id=? AND 
      status_id = ? AND
      origin_id != ?",
      array($locale_id, $language_id, 38, 0))
      ->groupBy('origin_id', 'name')
      ->get(array('origin_id', 'id', 'name'));
  }
    
  public static function getProductTypeOptions($locale_id, $language_id){
    return Product_Type::whereRaw("
      locale_id=? AND
      language_id=? AND
      status_id=?",
      array($locale_id, $language_id, 32))
      ->orderBy('ordernum')
      ->get(array('id', 'name'));
  }
    
  public static function getProductOptions($locale_id, $language_id){
    return Category::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ? AND
      parent_id = ? AND 
      isother = ?",
      array($locale_id,$language_id, 23, 0, 0))
      ->orderBy('name')
      ->get(array('id', 'name'));
  }
    
  public static function getVarietyOptions($locale_id, $language_id){
    return Category::whereRaw("
      locale_id = ? AND 
      language_id = ? AND
      status_id = ? AND
      parent_id != ? AND
      isother = ?",
      array($locale_id, $language_id, 23, 0, 0))
      ->OrderBy('parent_id', 'asc')
      ->OrderBy('name', 'asc')
      ->get(array('parent_id', 'id', 'name'));
  }
    
  public static function getBulkWeightTypeOptions($locale_id, $language_id){
    return Weight_type::whereRaw("
      locale_id = ? AND
      language_id = ? AND 
      status_id = ? AND
      isbulk = ?",
      array($locale_id, $language_id, 44, 1))
      ->OrderBy('name', 'asc')
      ->get(array('id', 'name', 'value_wrt_grams', 'system'));
      /* Per product unit */
  }
    
  public static function getCartonWeightTypeOptions($locale_id, $language_id){
    return Weight_type::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ? AND 
      isbulk = ?",
      array($locale_id, $language_id, 44, 0))
      ->OrderBy('name', 'asc')
      ->get(array('id', 'name', 'value_wrt_grams', 'system'));
  }
  
  public static function getBulkPackageOptions($locale_id, $language_id){
    return Package::whereRaw("
      locale_id = ? AND
      language_id = ? 
      AND status_id = ?
      AND isbulk = ?",
      array($locale_id, $language_id, 29, 1))
      ->OrderBy('ordernum', 'name', 'asc')
      ->get(array('id', 'name'));
  }
    
  public static function getCartonPackageOptions($locale_id, $language_id){
    return Package::whereRaw("
      locale_id = ? AND
      language_id = ? AND 
      status_id = ? AND
      isbulk = ?",
      array($locale_id, $language_id, 29, 0))
      ->OrderBy('ordernum', 'name', 'asc')
      ->get(array('id', 'name'));
  }
  
  public static function getMaturityOptions($locale_id, $language_id){
    return Maturity::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ?",
      array($locale_id, $language_id, 19))
      ->OrderBy('name', 'asc')
      ->get(array('id', 'name'));
  }
  
  public static function getColorsOptions($locale_id, $language_id){
    return Colour::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ?",
      array($locale_id, $language_id, 16))
      ->OrderBy('name', 'asc')
      ->get(array('id', 'name'));
  }
  
  public static function getQualityOptions($locale_id, $language_id){
    return Quality::whereRaw("
      locale_id = ? AND
      language_id = ? AND
      status_id = ?",
      array($locale_id, $language_id, 26))
      ->OrderBy('name', 'asc')
      ->get(array('id', 'name'));
  }
  
  public static function getOtherProvinceOptions($locale_id, $language_id){
    return Province::whereRaw("
      locale_id = ? AND
      language_id = ? AND 
      status_id = ? AND
      country_id != ?",
      array($locale_id, $language_id, 38, 0))
      ->groupBy('country_id', 'name')
      ->get(array('country_id', 'id', 'name'));
  }
  
  public static function getOtherCountryOptions($locale_id, $language_id){
    return Country::whereRaw("
      locale_id = ? AND 
      language_id = ? AND 
      status_id = ?",
      array($locale_id, $language_id, 41))
      ->orderBy('name')
      ->get(array('id', 'name'));			
  }
  
}
