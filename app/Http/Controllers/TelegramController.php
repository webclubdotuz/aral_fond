<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Api;
use Termwind\Components\Dd;

class TelegramController extends Controller
{

    public function index(Request $request)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $check = [
            [
                [
                    'text' => 'Танлаўда қатнасыў',
                    'callback_data' => 'check'
                ]
            ]
        ];

        $phone = [
            [
                [
                    'text' => '📞 Телефон номерди жибериў',
                    'request_contact' => true
                ]
            ]
        ];

        $bas_menu = '🔙 Бас меню';
        $jobs = [
            ['🗒Шығарма', '🌄Суўрет'],
            [$bas_menu]
        ];

        $jobs_menu = 'Танлаўға өз жумысыңызды жибериў';
        $main_menu = [
            [$jobs_menu],
            ['Анкета'],
        ];


        $rayon_keyboard = [
            [
                ['text' => 'Амударё тумани', 'callback_data' => 'Амударё тумани'],
                ['text' => 'Беруний тумани', 'callback_data' => 'Беруний тумани'],
            ],
            [
                ['text' => 'Бўзатов тумани', 'callback_data' => 'Бўзатов тумани'],
                ['text' => 'Кегейли тумани', 'callback_data' => 'Кегейли тумани'],
            ],
            [
                ['text' => 'Қонликўл тумани', 'callback_data' => 'Қонликўл тумани'],
                ['text' => 'Қораўзак тумани', 'callback_data' => 'Қораўзак тумани'],
            ],
            [
                ['text' => 'Қўнғирот тумани', 'callback_data' => 'Қўнғирот тумани'],
                ['text' => 'Мўйноқ тумани', 'callback_data' => 'Мўйноқ тумани'],
            ],
            [
                ['text' => 'Нукус тумани', 'callback_data' => 'Нукус тумани'],
                ['text' => 'Нукус шаҳри', 'callback_data' => 'Нукус шаҳри'],
            ],
            [
                ['text' => 'Тахиатош тумани', 'callback_data' => 'Тахиатош тумани'],
                ['text' => 'Тахтакўпир тумани', 'callback_data' => 'Тахтакўпир тумани'],
            ],
            [
                ['text' => 'Тўрткўл тумани', 'callback_data' => 'Тўрткўл тумани'],
                ['text' => 'Хўжайли тумани', 'callback_data' => 'Хўжайли тумани'],
            ],
            [
                ['text' => 'Чимбой тумани', 'callback_data' => 'Чимбой тумани'],
                ['text' => 'Шўманой тумани', 'callback_data' => 'Шўманой тумани'],
            ],
            [
                ['text' => 'Элликқалъа тумани', 'callback_data' => 'Элликқалъа тумани'],
            ]
        ];


        try {
            $chat_id = $request->input('message.chat.id');
            $text = $request->input('message.text');
            $callback_data = $request->input('callback_query.data');
            $callback_chat_id = $request->input('callback_query.from.id');
            $contact = $request->input('message.contact');

            $chat_id = $callback_chat_id ?? $chat_id;

            $personal = Personal::where('chat_id', $chat_id)->first();

            // send action
            $telegram->sendChatAction([
                'chat_id' => $chat_id,
                'action' => 'typing'
            ]);

            if (!$personal) {
                $personal = Personal::create([
                    'chat_id' => $chat_id,
                ]);
            }

            if($bas_menu == $text){
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Бас меню',
                    'reply_markup' => json_encode([
                        'keyboard' => $main_menu,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => false
                    ])
                ]);
            }

            if($jobs_menu == $text){

                $personal->map = 'jobs_menu';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Танлаўға өз жумысыңызды жибериў',
                    'reply_markup' => json_encode([
                        'keyboard' => $jobs,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => false
                    ])
                ]);
            }


            if ($text == '/start') {

                $start_text = "Ассалаўма алейкум хүрметли қатнасыўшы, Жаңа Арал балалар нәзеринде конкурсына хош келипсиз!.
                \nТанлаў 2 басқышта өткериледи ✅
                \n🟡1-Басқыш: Қала ҳәм район басқышы, сиз өзиңиздиң «Жаңа Арал балалар нәзеринде» темасына өз шығарма жумысыңызды 🗒 яки суўретлеў жумысыңызды 🌄 бот арқалы бизге жибериўиңиз керек.
                \n🟢2-Басқыш: Экспертлеримиз ең жақсы шығарма жумысын ҳәм жазба жумысларын сайлып 2-басқышқа өткереди. 2-басқыш 20-21 апрель күни Мойнақ районы 🌈 Ақ-Кеме балалар дем алыў орайында болып өтеди. Жол, жатақ жай қәрежетлери толык биз тәрепимизден қапланады.
                \n✅Танлаўға өз жумысыңызды жибериў ушын төмендеги кнопканы басың";

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $start_text,
                    'parse_mode' => 'html',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => $check
                    ])
                ]);

                exit;
            }

            if($callback_data == 'check'){
                $telegram->editMessageText([
                    'chat_id' => $chat_id,
                    'message_id' => $request->input('callback_query.message.message_id'),
                    'text' => $request->input('callback_query.message.text'),
                    'reply_markup' => json_encode([
                        'inline_keyboard' => []
                    ])
                ]);
                if($personal->is_active)
                {
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Жөнелисиңизди сайлаң:',
                        'reply_markup' => json_encode([
                            'keyboard' => $jobs,
                            'resize_keyboard' => true,
                        ])
                    ]);
                    exit;
                }else{

                    // edit message

                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Сиз дизимнен өтпегенсиз, дизимнен өтиў ушын төмендеги кнопка арқалы телефон номериңизди жоллаң',
                        'reply_markup' => json_encode([
                            'keyboard' => $phone,
                            'resize_keyboard' => true,
                        ])
                    ]);

                    $personal->map = 'phone';
                    $personal->save();

                    exit;
                }
            }

            // register phone
            if($personal->map == 'phone' && $contact){
                $personal->phone = $contact['phone_number'];
                $personal->map = 'fullname';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Фамилия атыңызды киргизиң',
                    'reply_markup' => json_encode([
                        'remove_keyboard' => true
                    ])
                ]);

                exit;
            }

            // register fullname
            if($personal->map == 'fullname' && $text){
                $personal->fullname = $text;
                $personal->map = 'birthday';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Туўылған сәнеңизди киргизиң (27.04.2006)',
                    'reply_markup' => json_encode([
                        'remove_keyboard' => true
                    ])
                ]);

                exit;
            }

            // register birthday
            if($personal->map == 'birthday' && $text){
                $birthday = explode('.', $text);
                if(count($birthday) != 3){
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Туўылған сәнеңизди киргизиң (27.04.2006)',
                        'reply_markup' => json_encode([
                            'remove_keyboard' => true
                        ])
                    ]);
                    exit;
                }
                // check birthday
                if($birthday[0] > 31 || $birthday[1] > 12 || $birthday[2] > date('Y')){
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Туўылған сәнеңизди киргизиң (27.04.2006)',
                        'reply_markup' => json_encode([
                            'remove_keyboard' => true
                        ])
                    ]);
                    exit;
                }

                $personal->birthday = date('Y-m-d', strtotime($text));
                $personal->map = 'rayon';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Район қалаңызды сайлаң',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => $rayon_keyboard
                    ])
                ]);
                exit;
            }

            // register rayon
            if($personal->map == 'rayon' && $callback_data){
                // edit rayon message
                $telegram->editMessageText([
                    'chat_id' => $chat_id,
                    'message_id' => $request->input('callback_query.message.message_id'),
                    'text' => "Район қалаңызды сайлаң \n <b>$callback_data</b>",
                    'parse_mode' => 'html',
                    // empty keyboard
                    'reply_markup' => json_encode([
                        'inline_keyboard' => []
                    ])
                ]);

                // exit;

                $personal->rayon = $callback_data;
                $personal->map = 'school';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Мектебиңизди киргизиң (Мысалы: 1)',
                    'reply_markup' => json_encode([
                        'remove_keyboard' => true
                    ])
                ]);
                exit;
            }

            // register school
            if($personal->map == 'school' && $text){
                // validate school
                if(!$text > 0 || !is_numeric($text)){
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Мектебиңизди киргизиң (Мысалы: 22)',
                        'reply_markup' => json_encode([
                            'remove_keyboard' => true
                        ])
                    ]);
                    exit;
                }

                $personal->school = $text;
                $personal->map = 'class';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Класыңызды киритиң (Мысалы: 7)',
                    'reply_markup' => json_encode([
                        'remove_keyboard' => true
                    ])
                ]);
                exit;
            }

            // register class
            if($personal->map == 'class' && $text){
                // validate class
                if(!$text>0 || !is_numeric($text)){
                    $telegram->sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Класыңызды киритиң (Мысалы: 1)',
                        'reply_markup' => json_encode([
                            'remove_keyboard' => true
                        ])
                    ]);
                    exit;
                }

                $personal->class = $text;
                $personal->map = 'anketa_check';
                $personal->save();

                $personal = Personal::where('chat_id', $chat_id)->first();

                // send anketa
                $text = "Анкета \n";
                $text .= "Телефон: <b>$personal->phone</b> \n";
                $text .= "Фамилия аты: <b>$personal->fullname</b> \n";
                $text .= "Туўылған сәне: <b>$personal->birthday</b> \n";
                $text .= "Район қала: <b>$personal->rayon</b> \n";
                $text .= "Мектеп: <b>$personal->school</b>-мектеп \n";
                $text .= "Класс: <b>$personal->class</b>-класс \n";

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $text,
                    'parse_mode' => 'html',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => '✅Тастыйықлау',
                                    'callback_data' => 'anketa_check'
                                ],
                                [
                                    'text' => '🔙Артқа',
                                    'callback_data' => 'anketa_back'
                                ]
                            ]
                        ]
                    ])
                ]);

                exit;
            }

            // anketa check
            if($personal->map == 'anketa_check' && $callback_data == 'anketa_check'){

                // edit anketa message
                $telegram->editMessageText([
                    'chat_id' => $chat_id,
                    'message_id' => $request->input('callback_query.message.message_id'),
                    'text' => $request->input('callback_query.message.text'),
                    'parse_mode' => 'html',
                    // empty keyboard
                    'reply_markup' => json_encode([
                        'inline_keyboard' => []
                    ])
                ]);


                $personal->map = 'jobs_menu';
                $personal->is_active = 1;
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => '✅ Сиздиң анкетаңыз қабылланды',
                ]);

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Жөнелисиңизди сайлаң: ',
                    'reply_markup' => json_encode([
                        'keyboard' => $jobs,
                        'resize_keyboard' => true,
                    ])
                ]);
                exit;
            }

            // 🗒Шығарма
            if($personal->is_active && $text == '🗒Шығарма'){
                $personal->map = 'shigarma';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Шығармаңыз егер бир неше бетлерден ибарат болса бирлестирип, PDF форматына айлантырып ботқа жибериң',
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                [
                                    'text' => '🔙 Бас меню'
                                ]
                            ]
                        ],
                        'resize_keyboard' => true,
                    ])
                ]);

                $personal->map = 'text';
                $personal->save();
                Job::where('personal_id', $personal->id)->where('status', 'passive')->delete();

                $jobs = Job::create([
                    'personal_id' => $personal->id,
                    'job' => 'text',
                    'status' => 'passive'
                ]);

                exit;
            }

            // 🌄Суўрет
            if($personal->is_active && $text == '🌄Суўрет'){
                $personal->map = 'photo';
                $personal->save();

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Суўретиңизди PDF яки 1 дана суўрет форматында ботқа жибериң',
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            [
                                [
                                    'text' => '🔙 Бас меню'
                                ]
                            ]
                        ],
                        'resize_keyboard' => true,
                    ])
                ]);

                $personal->map = 'photo';
                $personal->save();

                Job::where('personal_id', $personal->id)->where('status', 'passive')->delete();

                $jobs = Job::create([
                    'personal_id' => $personal->id,
                    'type' => 'photo',
                    'status' => 'passive'
                ]);

                exit;
            }

            // get document or photo
            if($personal->is_active && $personal->map == 'photo' || $personal->map == 'text')
            {

                if($request->input('message.document.file_id')){
                    $file_id = $request->input('message.document.file_id');

                    $file_ext = $request->input('message.document.file_name');
                    $file_ext = explode('.', $file_ext);
                    $file_ext = end($file_ext);

                    if($file_ext != 'pdf' && $file_ext != 'PDF' && $file_ext != 'jpg' && $file_ext != 'jpeg' && $file_ext != 'png'){
                        $telegram->sendMessage([
                            'chat_id' => $chat_id,
                            'text' => 'Файл форматы жарамсыз. PDF яки суўрет форматында ботқа жибериң',
                        ]);
                        exit;
                    }

                }
                if($request->input('message.photo')){
                    $count = count($request->input('message.photo')) - 1;
                    $file_id = $request->input('message.photo.'.$count.'.file_id');
                }


                $file_name = $request->input('message.document.file_name') ?? $request->input('message.photo.0.file_unique_id') . '.jpg';

                $response = $telegram->getFile(['file_id' => $file_id]);

                $file = "https://api.telegram.org/file/bot" . env('TELEGRAM_BOT_TOKEN') . "/" . $response->getFilePath();
                $contents = file_get_contents($file);
                $path_url = "jobs/" . $file_name;
                $path_file = Storage::disk('public')->put($path_url, $contents);


                $job = Job::where('personal_id', $personal->id)->where('status', 'passive')->first();
                $job->file_path = $path_url;
                $job->save();

                $jobs_txt = "Файлыңыз қабылланды ✅\n\n";
                $jobs_txt .= "👤 Ф.А.Ә: " . $personal->fullname . "\n";
                $jobs_txt .= "📍 Мәнзили: " . $personal->address . "\n";
                $jobs_txt .= "📞 Телефон: " . $personal->phone . "\n";
                $jobs_txt .= "✉️ Таңлаў түри: ";
                // $jobs_txt .= $job->type == 'text' ? 'Шығарма' : 'Суўрет' . "\n\n";
                if($job->type == 'text'){
                    $jobs_txt .= 'Шығарма' . "\n\n";
                }else{
                    $jobs_txt .= 'Суўрет' . "\n\n";
                }

                $jobs_txt .= "Танлаўда қатнасыў ушын тастыйықлаў кнопкасын басың";

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $jobs_txt,
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [
                                [
                                    'text' => '✅ Тастыйықлаў',
                                    'callback_data' => 'confirm'
                                ],
                                [
                                    'text' => '❌ Бийкарлаў',
                                    'callback_data' => 'cancel'
                                ]
                            ]
                        ]
                    ])
                ]);

                $personal->map = 'confirm';
                $personal->save();

                exit;

            }

            if($personal->is_active && $callback_data == 'confirm'){

                $job = Job::where('personal_id', $personal->id)->where('status', 'passive')->first();
                $job->status = 'active';
                $job->save();

                // Рахмет 😊, Сиздиң жумысыңыз  қабылланды, ҳәм 5466 санлы ID менен дизимге алынды. Танлаўымызда актив қатнасқаныңыз ушын рахмет, кейинги басқышқа өткенлигиңиз ҳақкында қосымша хабарландырамыз ✅
                $text = "Рахмет 😊, Сиздиң жумысыңыз  қабылланды, ҳәм " . $job->id . " санлы ID менен дизимге алынды. Танлаўымызда актив қатнасқаныңыз ушын рахмет, кейинги басқышқа өткенлигиңиз ҳақкында қосымша хабарландырамыз ✅";

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $text,
                ]);

                $old_text = $request->input('callback_query.message.text');
                // "Танлаўда қатнасыў ушын тастыйықлаў кнопкасын басың" cut text last line
                $old_text = substr($old_text, 0, strrpos($old_text, "\n"));

                $telegram->editMessageText([
                    'chat_id' => $chat_id,
                    'message_id' => $request->input('callback_query.message.message_id'),
                    'text' => $old_text,
                    'reply_markup' => json_encode([
                        'inline_keyboard' => []
                    ])
                ]);

                $personal->map = 'main';
                $personal->save();

                exit;
            }

            if($personal->is_active && $text == "Анкета"){
                $anketa = "";
                $anketa .= "👤 Ф.А.Ә: " . $personal->fullname . "\n";
                $anketa .= "📞 Телефон: " . $personal->phone . "\n";
                $anketa .= "📍 Мәнзили: " . $personal->rayon . "\n";
                $anketa .= "🏫 Мектеп: " . $personal->school . "\n";
                $anketa .= "📚 Класс: " . $personal->class . "\n";

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $anketa,
                ]);

                $personal->map = 'anketa';
                $personal->save();

                exit;
            }



            // $telegram->sendMessage([
            //     'chat_id' => "1608513980",
            //     'text' => json_encode($request->all(), JSON_PRETTY_PRINT)
            // ]);
        } catch (\Throwable $th) {
            //throw $th;
            $telegram->sendMessage([
                'chat_id' => "1608513980",
                'text' => $th->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
