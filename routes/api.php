<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:api', 'role:teacher']], function () {
    Route::get('/groups/search', 'Api\v1\GroupController@search')->name('groups.search');
    Route::resource('/groups', 'Api\v1\GroupController');
});
