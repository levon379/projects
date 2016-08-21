<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PromosProduct extends Model {

    protected $fillable = [];


    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function options(){
        return $this->belongsToMany('App\ProductOption','promos_products_options' , 'promo_product_id','product_option_id');
    }

    public function addons(){
        return $this->belongsToMany('App\Addon','promos_products_addons' , 'promo_product_id','addon_id');
    }

    public function delete()
    {
        // delete all related photos
        //$this->element()->delete();
        // it's an uglier alternative, but faster

        PromosProductsAddon::where('promo_product_id',$this->id)->delete();
        PromosProductsOption::where('promo_product_id',$this->id)->delete();

        // delete the user
        return parent::delete();
    }

}
