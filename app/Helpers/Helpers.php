<?php

use App\Contact;
use App\Email;
use App\Image;
use App\PhoneNumber;
use Illuminate\Http\JsonResponse;

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

if (!function_exists('handleImageInUpdateContact')) {
    function handleImageInUpdateContact($files, $contact): void
    {
        if ($files) {
            $contact->has('image') ? updateImage($files, $contact) : storeImage($files, $contact);
        } else {
            if ($contact->has('image'))
                $contact->image()->delete();
        }
    }
}

if (!function_exists('storePhones')) {
    function storePhones($phones, $contactId): void
    {
        foreach ($phones as $pn) {
            PhoneNumber::create([
                'contact_id' => $contactId,
                'phone_number' => $pn['phone'],
                'type' => $pn['type']
            ]);
        }
    }
}

if (!function_exists('storeEmails')) {
    function storeEmails($emails, $contactId): void
    {
        foreach ($emails as $email) {
            Email::create([
                'contact_id' => $contactId,
                'email_address' => $email
            ]);
        }
    }
}

if (!function_exists('createContactWithRelations')) {
    function createContactWithRelations($request): void
    {
        $contactId = Contact::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'family' => $request->input('family'),
            'type' => $request->input('checkBox') == 'on' ? 'shared' : 'private'
        ])->id;

        storePhones($request->input('phones'), $contactId);
        storeEmails($request->input('emails'), $contactId);

        if ($file = $request->file('photo_name'))
            storeImage($file, Contact::find($contactId));
    }
}

if (!function_exists('jsonResponseWithMessage')) {
    function jsonResponseWithMessage(string $message, int $statusCode): JsonResponse
    {
        return response()->json(['message' => $message], $statusCode);
    }
}

if (!function_exists('jsonResponseHandler')) {
    function jsonResponseHandler(int $statusCode)
    {
        $messages = [
            200 => 'success',
            201 => 'created',
            401 => 'unauthorized',
            403 => 'unauthenticated',
            404 => 'not found'
        ];

        return jsonResponseWithMessage($messages[$statusCode], $statusCode);
    }
}
