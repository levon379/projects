<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailabilityRule extends Model {

	protected $fillable = [];


    public function slot()
    {
        // foreign key here
        return $this->belongsTo('App\AvailabilitySlot','availability_slot_id');
    }
}
