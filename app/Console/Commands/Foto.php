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

        $count = 1;
        foreach($jobs as $job)
        {
            if($count <= 351)
            {
                $job->user_id = 4;
            }
            elseif($count > 351 && $count <= 702)
            {
                $job->user_id = 5;
            }
            elseif($count > 702)
            {
                $job->user_id = 6;
            }
            $job->save();
            $count++;
        }
    }
}
