<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $guarded = [];

    public static function insertEmail($contactId, $email)
    {
        Email::create([
            'contact_id' => $contactId,
            'email_address' => $email
        ]);
    }

    //Relationships
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

}
