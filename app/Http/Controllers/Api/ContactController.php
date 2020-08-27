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
        createContactWithRelations($request);

        return jsonResponseHandler(201);
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
                return jsonResponseHandler(401);
        } catch (ModelNotFoundException $e) {
            return jsonResponseHandler(404);
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
            return jsonResponseHandler(404);

        $contact->update([
            'name' => $request->input('name'),
            'family' => $request->input('family'),
            'type' => $request->input('checkBox') == 'on' ? 'shared' : 'private'
        ]);

        PhoneNumber::where('contact_id', $contact->id)->delete();
        Email::where('contact_id', $contact->id)->delete();

        storePhones($request->input('phones'), $contact->id);
        storeEmails($request->input('emails'), $contact->id);

        handleImageInUpdateContact($request->file('photo_name'), $contact);

        return jsonResponseHandler(200);
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
            if (Contact::findOrFail($id)->user_id !== auth()->id())
                return jsonResponseHandler(401);

            Contact::destroy($id);
            return jsonResponseHandler(200);

        } catch (ModelNotFoundException $e) {
            return jsonResponseHandler(404);
        }
    }

}
