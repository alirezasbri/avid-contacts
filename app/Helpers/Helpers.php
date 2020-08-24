<?php

use App\Contact;
use App\Image;

if (!function_exists('storeImage')) {
    function storeImage($file, $contact)
    {
        if ($file) {
            $destinationPath = 'public/image/'; // upload path
            $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profileImage);
            $image = new Image(['image' => $profileImage]);
            $contact->image()->save($image);
        }
    }
}
