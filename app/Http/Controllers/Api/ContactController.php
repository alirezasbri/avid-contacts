<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Email;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\Contact as ContactResource;
use App\PhoneNumber;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ContactResource::collection(Contact::where('user_id', auth()->id())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContactRequest $request
     * @return void
     */
    public function store(StoreContactRequest $request)
    {
        $contactId = Contact::insertContact(
            auth()->id(),
            $request->input('name'),
            $request->input('family'),
            $request->input('checkBox') == 'on' ? 'shared' : 'private');


        foreach ($request->input('phones') as $pn) {
            PhoneNumber::insertPhoneNumber($contactId, $pn['phone'], $pn['type']);
        }

        foreach ($request->input('emails') as $email) {
            Email::insertEmail($contactId, $email);
        }

        if ($file = $request->file('photo_name'))
            storeImage($file, Contact::find($contactId));

        return response()->json(['message' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ContactResource
     */
    public function show($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            if (!is_null($contact) && $contact->user_id === auth()->id())
                return new ContactResource($contact);
            else
                return response()->json(['message' => 'unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'user not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactRequest $request
     * @param int $id
     * @return void
     */
    public function update(UpdateContactRequest $request, $id)
    {

        if (!$contact = Contact::find($id))
            return response()->json(['message' => 'contact not found'], 404);

        $contact->update([
            'name' => $request->input('name'),
            'family' => $request->input('family'),
            'type' => $request->input('checkBox') == 'on' ? 'shared' : 'private'
        ]);

        PhoneNumber::where('contact_id', $contact->id)->delete();
        foreach ($request->input('phones') as $pn) {
            PhoneNumber::insertPhoneNumber($contact->id, $pn['phone'], $pn['type']);
        }

        Email::where('contact_id', $contact->id)->delete();
        foreach ($request->input('emails') as $email) {
            Email::insertEmail($contact->id, $email);
        }
        if ($file = $request->file('photo_name'))
            updateImage($file, Contact::find($id));

        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            if (!is_null($contact) && $contact->user_id === auth()->id()) {
                Contact::destroy($id);
                return response()->json(['message' => 'success'], 200);
            } else
                return response()->json(['message' => 'unauthorized'], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'user not found'], 404);
        }
    }

}
