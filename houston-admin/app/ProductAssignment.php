<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAssignment extends Model {

    public function guides(){
        return $this->belongsToMany('App\User','product_assigned_guides' , 'product_assignment_id','guide_user_id');
    }
} 