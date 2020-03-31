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


Route::get('/fm', 'TeacherController@viewFilemanager')->name('show');

Route::group(['middleware' => ['auth', 'role:teacher']], function () {
    Route::get('/teacher', 'TeacherController@index')->name('teacher.index');
    Route::get('/add-students', 'TeacherController@addStudents')->name('teacher.add-students');
    Route::get('/view-students', 'TeacherController@viewStudents')->name('teacher.view-students');
    Route::get('/tests', 'TestController@tests')->name('test.tests');
});



Route::group(['middleware' => ['auth', 'role:student']], function () {
    Route::get('/student', 'StudentController@index')->name('student.index');
});


