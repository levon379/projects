<?php namespace App;

use App\Libraries\Helpers;
use Illuminate\Database\Eloquent\Model;

class DepartureCityLanguageDetail extends Model {

    protected $fillable = [];

    public $timestamps = false;

    public function language()
    {
        return $this->belongsTo('App\Language','language_id');
    }

    public function departureCity()
    {
        return $this->belongsTo('App\DepartureCity','departure_city_id');
    }
}
