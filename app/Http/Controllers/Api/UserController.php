<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['token' => User::refreshToken(User::where('email', $request->email)->first()->id)], 200);
        }
        return \response()->json(['message' => 'unauthorized'], 401);

    }

    public function register()
    {
        $this->validate(\request(), [
            'email' => 'required|email:rfc,dns|min:5|max:32|unique:users',
            'password' => 'required|min:8|max:32',
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24'
        ]);

        $email = request('email');
        $password = request('password');
        $name = request('name');
        $family = request('family');

        if (!User::where('email', $email)->exists()) {
            $token = User::createUser($email, $password, $name, $family);
            return \response()->json(['message' => 'user created', 'token' => $token], 200);
        } else {
            return \response()->json(['message' => 'username is not available'], 200);
        }
    }

}
