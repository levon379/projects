<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SourceName extends Model {

	protected $fillable = [];

    public function group()
    {
        // foreign key here
        return $this->belongsTo('App\SourceGroup','source_group_id');
    }


    public function source_group()
    {
        return $this->belongsTo('App\SourceGroup','source_group_id');
    }
}
