<?php

namespace App\Http\Controllers;

use App\Models\Hard;
use Illuminate\Http\Request;

class HardController extends Controller
{
    public function index()
    {
        $hards = Hard::all();
        return view('pages.hards.index', compact('hards'));
    }
}
