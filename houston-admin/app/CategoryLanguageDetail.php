<?php namespace App;

use App\Libraries\Helpers;
use Illuminate\Database\Eloquent\Model;

class CategoryLanguageDetail extends Model {

    protected $fillable = [];

    public $timestamps = false;

    public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }
}
