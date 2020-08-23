<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'family' => $this->family,
            'phone_numbers' => PhoneNumber::collection($this->phoneNumbers),
            'emails' => Email::collection($this->emails)
        ];
    }

}
