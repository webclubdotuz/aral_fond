<?php

namespace App\View\Components;

use App\Models\Job;
use Illuminate\View\Component;

class JobFileView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $job;


    public function __construct($job)
    {
        $this->job = Job::find($job);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        $file = $this->job->file_path;
        dd($file);
        $file_extension = explode('.', $file);
        $file_extension = end($file_extension);

        if ($file_extension == 'pdf' || $file_extension == "PDF")
        {
            $file_extension = 'pdf';
        }else{
            $file_extension = 'image';
        }


        return view('components.job-file-view', [
            'job' => $this->job,
            'file_extension' => $file_extension
        ]);
    }
}
