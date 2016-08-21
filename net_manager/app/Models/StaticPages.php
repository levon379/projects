<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPages extends Model
{
    protected $table = 'static_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title', 'content', 'status'
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
   
}

