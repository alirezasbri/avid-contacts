<?php

use App\Contact;
use App\Email;
use App\PhoneNumber;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('user.login.form');
});

//User Routes
Route::name('user.login.form')->get('/login', function () {
    return view('user.login2');
});
Route::name('user.register.form')->get('/register', function () {
    return view('user.register');
});
Route::name('user.login')->post('/login', 'UserController@login');
Route::name('user.register')->post('/register', 'UserController@register');

//Contact Routes
Route::name('contact.index')->get('/user/{id}/contacts', 'ContactController@index');
//Route::name('contact.show')->get('/contact/{contact}', 'ContactController@show');
Route::name('contact.details')->get('/user/{id}/contact/{idContact}', 'ContactController@showContact');
Route::name('contact.create')->get('/contact/create', 'ContactController@createContact');
Route::name('contact.update')->get('/contact/update/{id}', 'ContactController@updateContact');
Route::name('contact.add.form')->get('/user/{userId}/add', function ($userId) {
    return view('contact.add', ['userId' => $userId]);
});
Route::name('contact.edit.form')->get('/contact/edit/{idContact}', function ($idContact) {
    $phoneNumbers = PhoneNumber::getPhoneNumbers($idContact);
    $emails = Email::getContactEmails($idContact);
    $contact = Contact::getContactByID($idContact);

//    $numbersStr = "";
//    foreach ($phoneNumbers as $phoneNumber) {
//        $numbersStr .= $phoneNumber->phone_number . ',';
//    }
//
//    $emailsStr = "";
//    foreach ($emails as $email) {
//        $emailsStr .= $email->email_address . ',';
//    }

    return view('contact.edit', ['idContact' => $idContact,
        'contact' => $contact,
        'phoneNumbers' => $phoneNumbers,
        'emails' => $emails]);
});

Route::name('contact.delete')->get('/user/{id}/contact/delete/{idContact}', 'ContactController@deleteContact');

Route::name('phoneNumber.delete')->get('/phonenumber/delete/{idPhoneNumber}', 'PhoneNumberController@deletePhoneNumber');
Route::name('email.delete')->get('/email/delete/{idEmail}', 'EmailController@deleteEmail');


Route::name('contact.add')->post('/user/{id}/contact/add', 'ContactController@addContact');
Route::name('contact.edit')->post('/contact/edit/{id}', 'ContactController@editContact');
Route::name('phoneNumber.add')->post('/contact/phonenumber/add/{id}', 'PhoneNumberController@addPhoneNumber');
