<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public static function insertImage($contactId, $image)
    {
        return Image::create([
            'image' => $image,
            'contact_id' => $contactId
        ])->id;
    }

    //Relationships
    function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
