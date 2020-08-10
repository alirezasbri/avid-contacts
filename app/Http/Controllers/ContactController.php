<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Email;
use App\Image;
use App\PhoneNumber;

class ContactController extends Controller
{
    function index()
    {
        if (session('isLogin', false)) {
//            dd(session('userId')->getId());
            $contacts = \App\Contact::where('user_id', session('userId'))->get();
            $publicContacts = Contact::where('type', 'public')->orWhere('type', 'shared')->get();
            return view('contact.contacts', ['publicContacts' => $publicContacts, 'contacts' => $contacts, 'userId' => session('userId')]);
        } else return redirect()->route('user.login.form');

    }

    function show(Contact $contact)
    {
//        return view('show_contact', ['contact' => Contact::find($id)]);
        return view('contact.show_contact', ['contact' => $contact]); //implicit bindings - id
    }

    function showContact($slug)
    {
        $isExistSlug = Contact::isExistSlug($slug);

        if (!$isExistSlug)
            abort(404);

        $contact = Contact::getContactBySlug($slug);
        $phoneNumbers = PhoneNumber::getPhoneNumbers($contact->id);
        $emails = Email::getContactEmails($contact->id);
        $editable = Contact::isContactEditable(session('userId'), $contact->user_id);
//        return dd($editable, $id, $contact);
        return view('contact.show', ['phoneNumbers' => $phoneNumbers, 'emails' => $emails, 'contact' => $contact, 'editable' => $editable]);
    }


    function addContact()
    {

        $this->validate(request(), [
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24',
            'emails' => ' required',
            'phones' => 'required'
        ]);

        if (\request('checkBox') == 'true')
            $type = "shared";
        else $type = "private";

        $contactId = Contact::insertContact(session('userId'), \request('name'), \request('family'), $type);

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


        if (request()->has('image') && request('image') != '') {
            $image = new Image(['image' => \request('image')]);
            $contact = Contact::find($contactId);
            $contact->image()->save($image);
        }


        $result = ["url" => route('contact.index', session('userId'))];
        return $result;
    }

    function editFormContact($slug)
    {
        $isExistSlug = Contact::isExistSlug($slug);

        if (!$isExistSlug)
            abort(404);
        $contact = Contact::getContactBySlug($slug);
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
        $result = ["url" => route('contact.index', $contact->user_id)];
        return $result;

    }

    public function deleteContact($id, $idContact)
    {
        return Contact::destroy($idContact);
    }


}
