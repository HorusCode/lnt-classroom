<?php

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


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login-view');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => ['auth', 'role:teacher']], function () {
    Route::get('/teacher', 'Teacher\TeacherController@index')->name('t-index');
    Route::get('/add-student', 'Teacher\TeacherController@addStudent')->name('t-add-student');
});

Route::group(['middleware' => ['auth', 'role:student']], function () {
    Route::get('/student', 'Student\StudentController@index')->name('s-index');
});


