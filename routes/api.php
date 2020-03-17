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
    Route::get('/groups/student', 'Api\v1\GroupController@grouped')->name('groups.student');
    Route::apiResources([
        '/groups' => 'Api\v1\GroupController',
        '/students' => 'Api\v1\StudentController',
        '/tests' => 'Api\v1\TestController',
    ]);
});


Route::post('/register', 'Api\v1\AuthController@register');
Route::post('/login', 'Api\v1\LoginController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user/me', 'Api\v1\LoginController@sendDataUser');
    Route::post('/logout', 'Api\v1\LoginController@logout');
    Route::apiResource('/ratings', 'Api\v1\RatingController');
    Route::post('/upload/image', 'Api\v1\UploadController@image');
    Route::delete('/delete/{type}/{name}', 'Api\v1\UploadController@deleteFile');
});
