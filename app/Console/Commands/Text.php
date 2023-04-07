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
        $jobs = Job::where('type', 'text')->get();

        // 7, 8, 9

        $count = 1;
        foreach($jobs as $job)
        {
            if($count <= 351)
            {
                $job->user_id = 7;
            }
            elseif($count <= 702)
            {
                $job->user_id = 8;
            }
            elseif($count <= 703)
            {
                $job->user_id = 9;
            }
            $job->save();
            $count++;
        }
    }
}
