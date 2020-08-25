<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $guarded = [];

    public static function insertPhoneNumber($contactId, $phoneNumber, $type)
    {
        PhoneNumber::create([
            'contact_id' => $contactId,
            'phone_number' => $phoneNumber,
            'type' => $type
        ]);
    }

    //Relationships
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

}
