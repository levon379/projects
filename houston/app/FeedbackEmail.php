<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackEmail extends Model {

	protected $fillable = [];
	
	public function provider()
    {
        // foreign key here
        return $this->belongsTo('App\Provider','provider_id');
    }
	
	public function language()
    {
        // foreign key here
        return $this->belongsTo('App\Language','language_id');
    }

}
