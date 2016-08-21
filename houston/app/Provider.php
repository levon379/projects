<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model {

	protected $fillable = [];

    public function images(){
        return $this->hasMany('App\FeedbackEmail','product_id' , 'id');
    }

}
