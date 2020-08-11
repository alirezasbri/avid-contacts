<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Image;
use Illuminate\Http\Request;


class ImageController extends Controller
{

    public function save()
    {
        request()->validate([
            'photo_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($files = \request()->file('photo_name')) {
            $destinationPath = 'public/image/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
        }


        return Response()->json(['photo_name' => $profileImage]);


    }
}
