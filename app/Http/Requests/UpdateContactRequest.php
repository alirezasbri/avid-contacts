<?php

namespace App\Http\Requests;

use App\Contact;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->id() === Contact::find($this->route('id'))->user_id)
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:16',
            'family' => 'required|min:3|max:24',
            'emails' => 'required|array|min:1',
            'emails.*' => 'email:rfc,dns',
            'phones' => 'required|array|min:1',
            'phones.*.phone' => ['regex:/^(\+98|0098|98|0)[1-9]\d{9}$/'],
            'types' => 'required|array|min:1',
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(['message' => 'unauthorized'], 403));
    }
}
