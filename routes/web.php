<?php

use App\Contact;
use App\Email;
use App\PhoneNumber;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();


Route::get('/', function () {
    if (Auth::check())
        return redirect()->route('contact.index');
    else
        return redirect()->route('login');
});

//Contact Routes
Route::name('contact.index')->get('/contact', 'ContactController@index');
Route::name('contact.add.form')->get('/contact/add', function () {
    return view('contact.add', ['userId' => Auth::id()]);
});
Route::name('contact.details')->get('/contact/{contactSlug}', 'ContactController@show');
Route::name('contact.update')->get('/contact/update/{id}', 'ContactController@update');
Route::name('contact.edit.form')->get('/contact/edit/{contactSlug}', 'ContactController@editForm');
Route::name('contact.delete')->get('/contact/delete/{idContact}', 'ContactController@delete');

Route::name('phoneNumber.delete')->get('/phonenumber/delete/{idPhoneNumber}', 'PhoneNumberController@deletePhoneNumber');
Route::name('email.delete')->get('/email/delete/{idEmail}', 'EmailController@deleteEmail');


Route::name('contact.add')->post('/contact/add', 'ContactController@add');
Route::name('contact.edit')->post('/contact/edit/{id}', 'ContactController@update');
Route::name('phoneNumber.add')->post('/contact/phonenumber/add/{id}', 'PhoneNumberController@addPhoneNumber');

//Image Routes
Route::name('image.save')->post('/save', 'ImageController@save');

