<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/contacts', 'Api\ContactController@index');
Route::get('/contacts/{id}', 'Api\ContactController@show');
Route::post('/contacts', 'Api\ContactController@store');
Route::put('/contacts/{id}', 'Api\ContactController@update');
Route::delete('/contacts/{id}', 'Api\ContactController@destroy');

Route::post('/register', 'Api\UserController@register');
Route::post('/login', 'Api\UserController@login');
Route::get('/logout', 'Api\UserController@logout');
