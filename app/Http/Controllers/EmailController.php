<?php

namespace App\Http\Controllers;

use App\Email;

class EmailController extends Controller
{
    public function deleteEmail($idEmail)
    {
        return Email::destroy($idEmail);
    }
}
