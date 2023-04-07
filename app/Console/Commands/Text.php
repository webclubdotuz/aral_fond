<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class Text extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobs = Job::where('type', 'text')->where('status', 'active')->get();
        // 4, 5, 6

        $count = 1;
        foreach($jobs as $job)
        {
            if($count <= 167)
            {
                $job->user_id = 7;
            }
            elseif($count <= 334)
            {
                $job->user_id = 8;
            }
            elseif($count > 334)
            {
                $job->user_id = 9;
            }
            $job->save();
            $count++;
        }
    }
}
