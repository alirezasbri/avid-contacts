<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Email;
use App\Image;
use App\PhoneNumber;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    function index()
    {
        $contacts = \App\Contact::where('user_id', Auth::id())->get();
        $publicContacts = Contact::where('type', 'public')->orWhere('type', 'shared')->get();
        return view('contact.contacts', ['publicContacts' => $publicContacts, 'contacts' => $contacts, 'userId' => Auth::id()]);
    }

    function showContact($slug)
    {
        $isExistSlug = Contact::isExistSlug($slug);

        if (!$isExistSlug)
            abort(404);

        $contact = Contact::getContactBySlug($slug);
        $phoneNumbers = PhoneNumber::getPhoneNumbers($contact->id);
        $emails = Email::getContactEmails($contact->id);
        $editable = Contact::isContactEditable(Auth::id(), $contact->user_id);
        return view('contact.show', ['phoneNumbers' => $phoneNumbers, 'emails' => $emails, 'contact' => $contact, 'editable' => $editable]);
    }

    function addContact()
    {

        $this->validate(request(), [
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24',
            'emails' => 'required|array|min:1',
            'emails.*' => 'email:rfc,dns',
            'phones' => 'required|array|min:1',
            'phones.*' => ['regex:/^(\+98|0098|98|0)[1-9]\d{9}$/'],
            'types' => 'required|array|min:1',
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if (\request('checkBox') == 'true')
            $type = "shared";
        else $type = "private";

        $contactId = Contact::insertContact(Auth::id(), \request('name'), \request('family'), $type);

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

//        if (request()->has('photo_name') && request('photo_name') != '') {
//        }


//        $result = ["url" => route('contact.index')];
        return redirect()->route('contact.index');
    }

    function editFormContact($slug)
    {
        $isExistSlug = Contact::isExistSlug($slug);

        if (!$isExistSlug)
            abort(404);
        $contact = Contact::getContactBySlug($slug);

        if (Auth::id() !== $contact->user_id)
            abort(403);
        $phoneNumbers = PhoneNumber::getPhoneNumbers($contact->id);
        $emails = Email::getContactEmails($contact->id);


        return view('contact.edit', ['contactSlug' => $contact->slug,
            'contact' => $contact,
            'phoneNumbers' => $phoneNumbers,
            'emails' => $emails]);

    }

    function editContact($id)
    {

        $phoneNumbers = PhoneNumber::getPhoneNumbers($id);
        $emails = Email::getContactEmails($id);

        $this->validate(request(), [
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24',
            'emails' => 'array|min:1',
            'emails.*' => 'email:rfc,dns',
            'phones' => 'array|min:1',
            'phones.*' => ['regex:/^(\+98|0098|98|0)[1-9]\d{9}$/']
        ]);

        if ($phoneNumbers->isEmpty()) {
            $this->validate(request(), [
                'phones' => 'required',
            ]);
        }

        if ($emails->isEmpty()) {
            $this->validate(request(), [
                'emails' => 'required',
            ]);
        }

        $contact = Contact::getContactByID($id);

        if (request('checkBox') == 'true')
            $type = "shared";
        else $type = "private";

        $contact->update([
            'name' => request('name'),
            'family' => request('family'),
            'type' => $type
        ]);

        if (request()->has('phones') && request()->has('types')) {
            $phones = array_values(request('phones'));
            $types = array_values(request('types'));
            $i = 0;
            foreach ($phones as $pn) {
                PhoneNumber::insertPhoneNumber($contact->id, $pn, $types[$i]);
                $i++;
            }
        }

        if (request()->has('emails')) {
            $emails = array_values(request('emails'));
            foreach ($emails as $email) {
                Email::insertEmail($contact->id, $email);
            }
        }

        if (request()->has('image') && request('image') != '') {
            $contact = Contact::find($contact->id);
            if (!is_null($contact->image))
                $contact->image()->update(['image' => \request('image')]);
            else {
                $image = new Image(['image' => \request('image')]);
                $contact->image()->save($image);
            }
        } else {
            $contact->image()->delete();
        }
        $result = ["url" => route('contact.index')];
        return $result;

    }

    public function deleteContact($id, $idContact)
    {
        return Contact::destroy($idContact);
    }


}
