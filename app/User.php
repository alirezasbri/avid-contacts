<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];

    protected $guarded = [];
    public $timestamps = false;

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

        if (User::where('user_name', $username)->exists()) {
            if (User::where('user_name', $username)->first()->password == $password)
                return true;
        } else {
            return false;
        }


    }

    public function scopeIsExist($query, $username, $password)
    {
        return $query->where('user_name', $username)->
        where('password', $password)->exists();
    }

    public function scopeGetUserID($query, $username)
    {
        return $query->where('user_name', $username)->first();
    }

    public function scopeIsUsernameExist($query, $username)
    {
        return $query->where('user_name', $username)->exists();
    }

    public static function createUser($userName, $password, $name, $family)
    {
        User::create([
            'user_name' => $userName,
            'password' => $password,
            'name' => $name,
            'family' => $family,
            'type' => 'regular'
        ]);
    }

    public static function isUserAdmin( $userId)
    {
        $userType = User::find($userId)->type;

        if ($userType == 'admin')
            return true;
        else
            return false;
    }

}
