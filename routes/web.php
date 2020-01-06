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

Route::get('/', function () {
    return view('login');
});
Route::get('/teacher', function () {
    return view('pages.teacher.index');
})->name('teacher-index');


Route::get('/student', function () {
    return view('pages.student.index');
})->name('student-index');;

