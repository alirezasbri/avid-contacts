<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Email;
use App\Http\Requests\AddContactRequest;
use App\Http\Requests\EditContactRequest;
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

    public function add(AddContactRequest $request)
    {
        $contactId = Contact::insertContact(auth()->id(), $request->input('name'),
            $request->input('family'),
            $request->input('checkBox') == 'on' ? 'shared' : 'private');

        $i = 0;
        foreach ($request->input('phones') as $pn) {
            PhoneNumber::insertPhoneNumber($contactId, $pn, $request->input('types')[$i]);
            $i++;
        }

        foreach ($request->input('emails') as $email) {
            Email::insertEmail($contactId, $email);
        }

        if ($files = $request->file('photo_name'))
            storeImage($files, Contact::find($contactId));

        return redirect()->route('contact.index');
    }

    function editFormContact($slug)
    {
        if (!$contact = Contact::where('slug', $slug)->first())
            abort(404);

        if (Auth::id() !== $contact->user_id)
            abort(403);

        return view('contact.edit', ['contactSlug' => $contact->slug,
            'contact' => $contact,
            'phoneNumbers' => $contact->phoneNumbers,
            'emails' => $contact->emails]);

    }

    function update(EditContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update([
            'name' => request('name'),
            'family' => request('family'),
            'type' => $request->input('checkBox') == 'on' ? 'shared' : 'private'
        ]);

        PhoneNumber::where('contact_id', $contact->id)->delete();
        $i = 0;
        foreach ($request->input('phones') as $pn) {
            PhoneNumber::insertPhoneNumber($contact->id, $pn, $request->input('types')[$i]);
            $i++;
        }

        Email::where('contact_id', $contact->id)->delete();
        foreach ($request->input('emails') as $email) {
            Email::insertEmail($contact->id, $email);
        }

        handleImageInUpdateContact($request->file('photo_name'), $contact);

        return redirect()->route('contact.details', $contact->slug);

    }

    public function deleteContact($id, $idContact)
    {
        return Contact::destroy($idContact);
    }


}
