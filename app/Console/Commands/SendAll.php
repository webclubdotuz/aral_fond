<?php

namespace App\Console\Commands;

use App\Models\Personal;
use Illuminate\Console\Command;
use Telegram\Bot\Api;

class SendAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendall';

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
        $personals = Personal::all();

        $token = env('TELEGRAM_BOT_TOKEN');
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $time = time();
        $count = 0;
        $count2 = 0;
        $error = 0;
        foreach ($personals as $personal) {
            echo $count2 . ") " . $personal->chat_id . PHP_EOL;


            try {
                //code...
                $telegram->sendMessage([
                    'chat_id' => $personal->chat_id,
                    'text' => "Assalawma aleykum húrmetli qatnasıwshı.  Búgin jumıslardı qabıllawdıń eń sonǵı múddeti.  1-Aprel saat 23:00 ge shekem SHÍǴARMA yaki SUWRET jumıslarıńızdi jiberseńiz boladı hám onnan keyin jumıslardı qabıllaw toxtatiladi❗️",
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                echo $th->getMessage() . PHP_EOL;
                $error++;
            }



            if($count == 35){
                sleep(1);
                $count = 0;
            }
            $count++;
            $count2++;

        }
        $time = time() - $time;

        // minutes
        $time = $time / 60;

        echo $time . PHP_EOL . PHP_EOL . PHP_EOL;
        echo $error . PHP_EOL . PHP_EOL . PHP_EOL;

        return 0;


    }
}
