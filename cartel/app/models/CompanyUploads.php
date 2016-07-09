<?php

class CompanyUploads extends Eloquent {

  protected $table = 'company_upload';
  protected $fillable = [];
  
  public static function storeCompanyFile($data)
  {
    $result = DB::table('company_upload')->insertGetId($data);
    return $result;
  }

  

  public static function getCompanyUploads($company_id) {
    $items = DB::select(DB::raw("
        SELECT c_u.* FROM company_upload c_u
        WHERE c_u.company_id=:company_id"), array(
                'company_id' => $company_id,
                    )
    );

    if (empty($items))
      return array();
    return $items;
  }
  
  public static function updateCompanyFile($file_id,$data)
  {
    $return = DB::table('company_upload')
            ->where('id', $file_id)
            ->update($data);
    return $return;
  }

  public static function getCompanyFile($image_id) {
    $file = DB::table('company_upload')->select('*')->where('id', '=', $image_id)->get();
    return $file[0];
  }

  public static function deleteCompanyImage($image_id) {
    $delete = DB::table('company_upload')->where('id', '=', $image_id)->delete();
    return $delete;
  }

}

?>