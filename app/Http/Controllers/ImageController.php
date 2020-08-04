<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Image;
use Illuminate\Http\Request;


class ImageController extends Controller
{

    public function index()
    {
        return view('contact.image');
    }

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

/*
class ImageController extends Controller
{
    public function index()
    {
        return view('contact.image');
    }

    public function save()
    {
        request()->validate([
            'fileUpload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($files = \request()->file('fileUpload')) {
            $destinationPath = 'public/image/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
//            $insert['image'] = "$profileImage";
        }
//        $check = Image::insertGetId($insert);

        $image = new Image(['image' => $profileImage]);

        $contact = Contact::find(1);

        $contact->image()->save($image);
//        Image::insertImage($contact->id, $profileImage);
//        $contact->save();

        return Redirect::to("image")
            ->withSuccess('Great! Image has been successfully uploaded.');

    }
}
*/
