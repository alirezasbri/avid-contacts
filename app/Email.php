<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    public function scopeGetContactEmails($query, $contactId)
    {
        return $query->where('contact_id', $contactId)->get();
    }

    public static function insertEmail($contactId, $email)
    {
        Email::create([
            'contact_id' => $contactId,
            'email_address' => $email
        ]);
    }

}
