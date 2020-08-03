<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    public function scopeGetContactByID($query, $id)
    {
        return $query->where('id', $id)->first();
    }

    public static function insertContact($userId, $name, $family)
    {
        $type = 'private';
        if (User::isUserAdmin($userId))
            $type = 'public';

        return Contact::create([
            'user_id' => $userId,
            'name' => $name,
            'family' => $family,
            'type' => $type
        ])->id;

    }
}
