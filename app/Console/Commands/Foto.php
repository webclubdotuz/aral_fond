<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\User;
use Illuminate\Console\Command;
use Termwind\Components\Dd;

class Foto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:photo';

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

        $jobs = Job::where('type', 'photo')->get();

        // 4,5,6

        $count = 1;
        foreach($jobs as $job)
        {
            if($count <= 250)
            {
                $job->user_id = 4;
            }
            elseif($count <= 500)
            {
                $job->user_id = 5;
            }
            elseif($count <= 750)
            {
                $job->user_id = 6;
            }
            $job->save();
            $count++;
        }
    }
}
