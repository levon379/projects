<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingComment extends Model {

	protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
