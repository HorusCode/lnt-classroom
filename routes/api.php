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
    Route::resource('/students', 'Api\v1\StudentController');
    Route::resource('/tests', 'Api\v1\TestController');
});


Route::post('/register', 'Api\v1\AuthController@register');
Route::post('/login', 'Api\v1\LoginController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Api\v1\LoginController@logout');
    Route::resource('/ratings', 'Api\v1\RatingController');
});
