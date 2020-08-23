<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'phones.*' => ['regex:/^(\+98|0098|98|0)[1-9]\d{9}$/'],
            'types' => 'required|array|min:1',
            'photo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
