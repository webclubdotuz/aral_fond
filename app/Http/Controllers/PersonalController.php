<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {

        $personals = Personal::paginate(25);

        return view('pages.personals.index');
    }
}
