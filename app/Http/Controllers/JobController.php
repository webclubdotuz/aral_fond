<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return view('pages.jobs.index');
    }
    public function text()
    {
        return view('pages.jobs.texts');
    }
    public function photo()
    {
        return view('pages.jobs.photos');
    }
}
