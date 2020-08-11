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
    if (session('isLogin', false))
        return redirect()->route('contact.index');
    else
        return redirect()->route('user.login.form');
});

//User Routes
Route::name('user.login.form')->get('/login', function () {
    if (session('isLogin', false))
        return redirect()->route('contact.index');
    else
        return view('user.login');
});
Route::name('user.register.form')->get('/register', function () {
    return view('user.register');
});
Route::name('user.logout')->get('/logout', 'UserController@logout');


Route::name('user.login')->post('/login', 'UserController@login');
Route::name('user.register')->post('/register', 'UserController@register');

//Contact Routes
Route::name('contact.index')->get('/contact', 'ContactController@index');
Route::name('contact.add.form')->get('/contact/add', function () {
    return view('contact.add', ['userId' => session('userId')]);
});
Route::name('contact.details')->get('/contact/{contactSlug}', 'ContactController@showContact');
Route::name('contact.update')->get('/contact/update/{id}', 'ContactController@updateContact');
Route::name('contact.edit.form')->get('/contact/edit/{contactSlug}', 'ContactController@editFormContact');

Route::name('contact.delete')->get('/user/{id}/contact/delete/{idContact}', 'ContactController@deleteContact');

Route::name('phoneNumber.delete')->get('/phonenumber/delete/{idPhoneNumber}', 'PhoneNumberController@deletePhoneNumber');
Route::name('email.delete')->get('/email/delete/{idEmail}', 'EmailController@deleteEmail');


Route::name('contact.add')->post('/contact/add', 'ContactController@addContact');
Route::name('contact.edit')->post('/contact/edit/{id}', 'ContactController@editContact');
Route::name('phoneNumber.add')->post('/contact/phonenumber/add/{id}', 'PhoneNumberController@addPhoneNumber');

//Image Routes
Route::name('image.show')->get('/image', 'ImageController@index');
Route::name('image.save')->post('/save', 'ImageController@save');
