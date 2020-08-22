<?php

use Illuminate\Http\Request;
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

Route::post('/contact/delete', 'ContactApiController@destroy');
Route::get('/contacts/{id}', 'ContactApiController@index');
Route::get('/contact/{id}', 'ContactApiController@show');
Route::post('/contact', 'ContactApiController@store');
Route::put('/contact/{id}', 'ContactApiController@update');

Route::post('/register', 'UserApiController@register');
Route::post('/login', 'UserApiController@login');
