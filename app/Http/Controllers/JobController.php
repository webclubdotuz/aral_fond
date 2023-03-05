<?php

namespace App\Http\Controllers;

use App\Models\Job;
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

    public function ball(Request $request, Job $job)
    {

        $user = auth()->user();
        if ($user->id != $job->user_id) {
            toast('You are not allowed to do this action', 'error');
            return redirect()->back()->with('error', 'You are not allowed to do this action');
        }

        if (isset($job->ball_date) && $job->ball_date != now()->format('Y-m-d')) {
            toast("Лимит", 'error');
            return redirect()->back();
        }

        $request->validate([
            'ball' => 'required|numeric|min:0|max:100',
        ]);


        $job->ball = $request->ball;
        $job->ball_date = now();
        $job->save();

        return redirect()->back()->with('success', 'Ball added successfully');
    }
}
