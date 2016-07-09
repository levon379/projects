<?php namespace App\Libraries\Repositories;


use App\Addon;
use App\Libraries\Helpers;
use App\ProductOption;

class AddonsRepository {

    public function checkIfPriceIsZero($id){
        $addon = Addon::find($id);
        return $addon->child_price > 0 ? false : true;
    }

} 