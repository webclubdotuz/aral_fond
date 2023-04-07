<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $ball_null = 0;
        $ball_is = 0;

        if(hasRole('admin'))
        {
            $ball_is = Job::where('ball', '!=', null)->where('status', 'active')->count();
            $ball_null = Job::where('ball', null)->where('status', 'active')->count();
        }else{
            $ball_is = Job::where('ball', '!=', null)->where('status', 'active')->where('user_id', auth()->user()->id)->count();
            $ball_null = Job::where('ball', null)->where('status', 'active')->where('user_id', auth()->user()->id)->count();
        }

        return view('home', compact('ball_null', 'ball_is'));
    }
}
