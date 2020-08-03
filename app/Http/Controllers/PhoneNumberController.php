<?php

namespace App\Http\Controllers;

use App\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    public function deletePhoneNumber($idPhoneNumber)
    {
        return PhoneNumber::destroy($idPhoneNumber);
    }

    function addPhoneNumber($id)
    {
        return PhoneNumber::insertPhoneNumber($contactId, $pn);

    }
}
