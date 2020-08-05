<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function login()
    {
        $username = request('username');
        $password = request('password');
        if (User::isExist($username, $password)) {
            session(['isLogin' => true]);
            session(['userId' => User::getUserID($username)->id]);
            return redirect()->route('contact.index');
        } else{
            return view('user.login2');
        }

//        dd(User::isExist($username, $password));
    }

    function logout()
    {
        session(['isLogin' => false]);
//        return dd(session('isLogin'));
        return redirect()->route('user.login.form');
    }

    function register()
    {
        $this->validate(\request(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'نام کاربری الزامیست',
            'password.required' => 'رمز عبور الزامیست'
        ]);

        $username = request('username');
        $password = request('password');
        $name = request('name');
        $family = request('family');

        if (!User::isUsernameExist($username)) {
            User::createUser($username, $password, $name, $family);
            return redirect()->route('user.login.form');
        } else {
            return 'username is not available';
        }

    }
}
