<?php

use App\Image;

if (!function_exists('storeImage')) {
    function storeImage($file, $contact): void
    {
        $contact->image()->save(new Image(['image' => prepareImage($file)]));
    }
}

if (!function_exists('updateImage')) {
    function updateImage($files, $contact): void
    {
        $contact->image()->update(['image' => prepareImage($files)]);
    }

    if (!function_exists('prepareImage')) {
        function prepareImage($files): string
        {
            $destinationPath = 'public/image/'; // upload path
            $imageName = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $imageName);
            return $imageName;
        }
    }
}
