<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function isExistUser($username, $password)
    {
        if (User::where('username', $username)->exists()) {
            if (User::where('username', $username)->first()->password == $password)
                return true;
        } else {
            return false;
        }
    }

    public static function isExist($username, $password)
    {
        if (Hash::check($password, User::where('username', $username)->first()->password))
            return true;
        else
            return false;
    }

    public function scopeGetUserID($query, $username)
    {
        return $query->where('username', $username)->first();
    }

    public function scopeIsUsernameExist($query, $username)
    {
        return $query->where('username', $username)->exists();
    }

    public static function createUser($userName, $password, $name, $family)
    {
        User::create([
            'username' => $userName,
            'password' => bcrypt($password),
            'name' => $name,
            'family' => $family,
            'type' => 'regular'
        ]);
    }

    public static function isUserAdmin($userId)
    {
        User::find($userId)->type == 'admin' ? true : false;
    }

    //Relationships
    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

}
