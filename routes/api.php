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

Route::group([
    'middleware' => ['auth:api', 'role:teacher'],
    'prefix' => 'v1',
], function () {
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

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/user/me', 'Api\v1\LoginController@sendDataUser');
    Route::get('/logout', 'Api\v1\LoginController@logout');
    Route::apiResource('/ratings', 'Api\v1\RatingController');
    Route::post('/upload/image', 'Api\v1\UploadController@image');
    Route::delete('/delete/{type}/{name}', 'Api\v1\UploadController@deleteFile');

    Route::group([
        'middleware' => ['createfolder', 'multiuser'],
        'as' => 'filemanager.',
        'prefix' => 'fm',
        'namespace' => 'Api\v1\Filemanager'
    ], function () {
        // display integration error messages
        Route::get('/errors', [
            'uses' => 'FilemanagerController@getErrors',
            'as' => 'getErrors',
        ]);

        // upload
        Route::any('/upload', [
            'uses' => 'UploadController@upload',
            'as' => 'upload',
        ]);

        // list images & files
        Route::get('/jsonitems', [
            'uses' => 'ItemsController@getItems',
            'as' => 'getItems',
        ]);

        Route::get('/move', [
            'uses' => 'ItemsController@move',
            'as' => 'move',
        ]);

        Route::get('/domove', [
            'uses' => 'ItemsController@domove',
            'as' => 'domove'
        ]);

        // folders
        Route::get('/newfolder', [
            'uses' => 'FolderController@getAddfolder',
            'as' => 'getAddfolder',
        ]);

        // list folders
        Route::get('/folders', [
            'uses' => 'FolderController@getFolders',
            'as' => 'getFolders',
        ]);

        // crop
        Route::get('/crop', [
            'uses' => 'CropController@getCrop',
            'as' => 'getCrop',
        ]);
        Route::get('/cropimage', [
            'uses' => 'CropController@getCropimage',
            'as' => 'getCropimage',
        ]);
        Route::get('/cropnewimage', [
            'uses' => 'CropController@getNewCropimage',
            'as' => 'getCropimage',
        ]);

        // rename
        Route::get('/rename', [
            'uses' => 'RenameController@getRename',
            'as' => 'getRename',
        ]);

        // scale/resize
        Route::get('/resize', [
            'uses' => 'ResizeController@getResize',
            'as' => 'getResize',
        ]);
        Route::get('/doresize', [
            'uses' => 'ResizeController@performResize',
            'as' => 'performResize',
        ]);

        // download
        Route::get('/download', [
            'uses' => 'DownloadController@getDownload',
            'as' => 'getDownload',
        ]);

        // delete
        Route::get('/delete', [
            'uses' => 'DeleteController@getDelete',
            'as' => 'getDelete',
        ]);
    });

});
