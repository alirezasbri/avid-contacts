<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    //Relationships
    function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
