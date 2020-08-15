<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $guarded = [];
    use Sluggable;

    public function scopeGetContactByID($query, $id)
    {
        return $query->where('id', $id)->first();
    }

    public function scopeGetContactBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->first();
    }

    public static function insertContact($userId, $name, $family, $type)
    {
        return Contact::create([
            'user_id' => $userId,
            'name' => $name,
            'family' => $family,
            'type' => User::isUserAdmin($userId) ? 'public' : $type
        ])->id;
    }

    public static function isContactEditable($userId, $contactUserId)
    {
        if ($userId == $contactUserId)
            return true;
        else return false;
    }

    public function scopeIsExistSlug($query, $slug)
    {
        return $query->where('slug', $slug)->exists();
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

    public function image()
    {
        return $this->hasOne('App\Image');
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'family'
            ]
        ];
    }
}
