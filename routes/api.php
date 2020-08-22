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

Route::get('/contacts', 'ContactApiController@index');
Route::get('/contacts/{id}', 'ContactApiController@show');
Route::post('/contacts', 'ContactApiController@store');
Route::put('/contacts/{id}', 'ContactApiController@update');
Route::delete('/contacts/{id}', 'ContactApiController@destroy');

Route::post('/register', 'UserApiController@register');
Route::post('/login', 'UserApiController@login');
