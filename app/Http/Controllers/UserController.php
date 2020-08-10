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
        } else {
            return view('user.login', ['error' => 'نام کاربری یا کلمه عبور اشتباه است']);
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
            'username' => 'required|min:5|max:16',
            'password' => 'required|min:8|max:32',
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24'
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
