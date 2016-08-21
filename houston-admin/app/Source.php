<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model {

    protected $table = "source_names_commissions";
    protected $fillable = [];

    public function product_option() {
        // foreign key here
        return $this->hasMany('App\ProductOption', 'product_opt_id', 'id');
    }

    public function source_name() {
        return $this->belongsTo('App\SourceName','source_name_id');
    }

}
