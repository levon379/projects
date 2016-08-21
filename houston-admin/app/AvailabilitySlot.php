<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model {

	protected $fillable = [];

    public function timeOfDays(){
        return $this->belongsToMany('App\TimeOfDay','availability_slot_tods');
    }

}
