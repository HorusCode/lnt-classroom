<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('pages.teacher.index');
    }
    public function addStudents()
    {
        return view('pages.add_human');
    }
    public function viewStudents()
    {
        return view('pages.all_human');
    }
}
