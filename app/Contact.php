<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $guarded = [];
//    public $timestamps = false;

    public function scopeGetContactByID($query, $id)
    {
        return $query->where('id', $id)->first();
    }

    public static function insertContact($userId, $name, $family, $type)
    {
//        $type = 'private';
        if (User::isUserAdmin($userId))
            $type = 'public';

        return Contact::create([
            'user_id' => $userId,
            'name' => $name,
            'family' => $family,
            'type' => $type
        ])->id;

    }

    public static function isContactEditable($userId, $contactUserId)
    {
        if ($userId == $contactUserId)
            return true;
        else false;
    }

    //Relationships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function emails()
    {
        return $this->hasMany('App\Email');
    }

    public function phoneNumbers()
    {
        return $this->hasMany('App\PhoneNumber');
    }

    public function image(){
        return $this->hasOne('App\Image');
    }
}
