<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Email;
use App\Image;
use App\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function index(int $userId)
    {
        return response()->json(['data' => Contact::where('user_id', $userId)->get()], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24',
            'emails' => 'required|array|min:1',
            'emails.*' => 'email:rfc,dns',
            'phones' => 'required|array|min:1',
            'phones.*' => ['regex:/^(\+98|0098|98|0)[1-9]\d{9}$/'],
            'types' => 'required|array|min:1',
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'userId' => 'required|exists:users,id'
        ]);

        $type = \request('checkBox') == 'on' ? 'shared' : 'private';

        $contactId = Contact::insertContact(\request('userId'), \request('name'), \request('family'), $type);

        if (request()->has('phones') && request()->has('types')) {
            $phones = array_values(request('phones'));
            $types = array_values(request('types'));
            $i = 0;
            foreach ($phones as $pn) {
                PhoneNumber::insertPhoneNumber($contactId, $pn, $types[$i]);
                $i++;
            }
        }
        if (request()->has('emails')) {
            $emails = array_values(request('emails'));
            foreach ($emails as $email) {
                Email::insertEmail($contactId, $email);
            }
        }

        if ($files = \request()->file('photo_name')) {
            $destinationPath = 'public/image/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);

            $image = new Image(['image' => $profileImage]);
            $contact = Contact::find($contactId);
            $contact->image()->save($image);
        }

        return response()->json(['data' => 'success', 200]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['data' => Contact::findOrFail($id), 200]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24',
            'emails' => 'required|array|min:1',
            'emails.*' => 'email:rfc,dns',
            'phones' => 'required|array|min:1',
            'phones.*' => ['regex:/^(\+98|0098|98|0)[1-9]\d{9}$/'],
            'types' => 'required|array|min:1',
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $contact = Contact::findOrFail($id);

        $type = \request('checkBox') == 'on' ? 'shared' : 'private';

        $contact->update([
            'name' => request('name'),
            'family' => request('family'),
            'type' => $type
        ]);

        if (request()->has('phones') && request()->has('types')) {
            PhoneNumber::where('contact_id', $contact->id)->delete();
            $phones = array_values(request('phones'));
            $types = array_values(request('types'));
            $i = 0;
            foreach ($phones as $pn) {
                PhoneNumber::insertPhoneNumber($contact->id, $pn, $types[$i]);
                $i++;
            }
        }

        if (request()->has('emails')) {
            Email::where('contact_id', $contact->id)->delete();
            $emails = array_values(request('emails'));
            foreach ($emails as $email) {
                Email::insertEmail($contact->id, $email);
            }
        }

        if ($files = \request()->file('photo_name')) {
            $destinationPath = 'public/image/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);

            $image = new Image(['image' => $profileImage]);

            if ($contact->has('image')) {
                $contact->image()->delete();
                $contact->image()->save($image);
            } else
                $contact->image()->save($image);
        } else {
            if ($contact->has('image'))
                $contact->image()->delete();
        }

        return response()->json(['data' => 'success', 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);

        return response()->json(['data' => 'success', 200]);
    }
}
