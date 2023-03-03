<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require '../../App/TelegramController.php';
require '../../Models/BotUser.php';
require '../../Models/Bot.php';
require '../../Models/Appeal.php';
require '../../Models/Reply.php';
require 'lang.php';

use App\Models\BotUser;
use App\Models\Reply;
use App\TelegramController;


date_default_timezone_set('Asia/Tashkent');

$config = require __DIR__.'/config.php';

$bot = new TelegramController($config['token']);

$kanal_chat_id = "-1001662170452";
$botModel = Bot::where('bot_id', '5511914180')->first();

$data = $bot->getData("php://input");
$chat_id = $data['message']['chat']['id'];
$user_id = $data['message']['from']['id'];
$username = $data['message']['from']['username'];
$ism = $data['message']['from']['first_name'].' '.$data['message']['from']['last_name'];
$text = $data['message']['text'];
$message_id = $data['message']['message_id'];

$in_data = json_encode($data, JSON_PRETTY_PRINT);

/** CallbackQuery */
$callback = $data['callback_query'];
$callback_id = $callback['id'];
$call_data = $callback['data'];
$call_chat_id = $callback['message']['chat']['id'];
$call_message_id = $callback['message']['message_id'];


/** Audio */
$audio = $data['message']['audio'];

/** Photo */
$photo = $data['message']['photo'];

/** Video */
$video = $data['message']['video'];

if($chat_id)
{
    $chat_id_base = $chat_id;
}
else{
    $chat_id_base = $call_chat_id;
}


$tg_user = BotUser::where('bot_id', $botModel->id)->where('user_id', $chat_id_base)->first();
$map = $tg_user['map'];
$user_lang = $tg_user['lang'] ? $tg_user['lang'] : 'qar';

$key = $bot->InlineKeyboard([
    [
        ['text' => $lang[$user_lang]['accepted'], 'callback_data' => 'accepted'],
        ['text' => $lang[$user_lang]["❌Бийкарлаў"], 'callback_data' => 'canceled']
    ]
]);

$key_empty = $bot->InlineKeyboard([]);

$inline_lang_key = $bot->InlineKeyboard([
    [
        ['text' => 'Қарақалпақ', 'callback_data' => 'Қарақалпақ'],
        ['text' => 'Ўзбек', 'callback_data' => 'Ўзбек'],
        ['text' => 'Русский', 'callback_data' => 'Русский'],
    ]
]);

$key_file = $bot->InlineKeyboard([
    [
        ['text' => $lang[$user_lang]["yes"], 'callback_data' => 'files_yes'],
        ['text' => $lang[$user_lang]["no"], 'callback_data' => 'no_files']
    ]
]);


$murajaat = $lang[$user_lang]["✉️Мурәжаат қалдырыў"];
$cancel = $lang[$user_lang]["❌Бийкарлаў"];
$keyboard = $bot->ReplyKeyboardMarkup([
   [$murajaat]
], true);

$lang_keyboard = $bot->ReplyKeyboardMarkup([
    ['Қарақалпақ'],
    ['Ўзбек'],
    ['Русский']
 ], true);

$keyboard_cancel = $bot->ReplyKeyboardMarkup([
   [$cancel]
], true);

$rayon_keyboard = $bot->InlineKeyboard([
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
]);



$bot->sendChatAction([
    'chat_id' => $chat_id_base,
    'action' => "typing"
]);




$text1 = "
Қарақалпақстан Республика Жоқарғы Кеңеси тәрепинен «Халық мүрәжаты» платформасы иске түсирилгенлигин мәлим етемиз ! 📲

Сизиң өз аймағыңыздағы машқаланы «Халық мүрәжаты» мобил қосымшасы арқалы Қаракалпакстан Республикасы Жоқарғы Кеңесине жоллай алыў имканиятыңыз бар.✅ 

Қала тазалығы, жол, электр энергиясы, тәбийғый газ, ишимлик суў мәселесиндеги машқалаңызды Халық мүрәжаты платформасынан дизимнен өтип бизге жоллаң. 

Платформа арқалы Қарақалпақстан Республикасы Жоқарғы Кеңесине де туўрыдан-туўры мүрәжат етиў имканиятыңыз бар.

Қосымшаны жүклеп алыў
⬇️⬇️⬇️⬇️⬇️⬇️
Google Play Market (Android) 
https://play.google.com/store/apps/details?id=com.bizmiz.appeal

Мобил қосымшаны тез арада AppStore арқалы да жүклеп алсаңыз болады.";


 $bot->sendMessage([
   'chat_id' => $chat_id,
    'text' => $text1
  ]);
exit;
    
$video_path = "BAACAgIAAxkBAAIHl2OZ3iCJOXv_1cn4145gSl_5gQMxAAJhIAACa5jQSMhrTe2RGG2xLAQ";
/*$bot->sendVideo([
    'chat_id' => $chat_id,
    'video' => $video_path,
    'caption' => $text1,
    // 'reply_markup' => $rayon_keyboard
]); 
exit;*/


// $bot->sendMessage([
//     'chat_id' => $chat_id_base,
//     'text' => $in_data
//   ]);


if($call_data == 'good'){

    $reply = Reply::where('msg_id', $callback["message"]["message_id"])->where('bot_id', $botModel->bot_id)->first();
    $reply->update([
        "status" => "good"
    ], ['msg_id'=>$callback["message"]["reply_to_message"]["message_id"], 'bot_id', $botModel->bot_id]);

    $bot->editMessageText([
        'chat_id' => $call_chat_id,
        'text'=>$reply->text,
        'message_id' => $callback["message"]["message_id"],
        'reply_markup' => $ok_key,
    ]);

    $bot->sendMessage([
        'chat_id' => $call_chat_id,
        'text'=>$reply->text,
        'message_id' => $callback["message"]["message_id"],
        'reply_markup' => $ok_key,
    ]);
    exit();
}

if($call_data == 'against'){
    $reply = Reply::where('msg_id', $callback["message"]["message_id"])->where('bot_id', $botModel->bot_id)->first();
    $reply->update([
        "status" => "against"
    ], ['msg_id'=>$callback["message"]["reply_to_message"]["message_id"], 'bot_id', $botModel->bot_id]);

    $bot->editMessageText([
        'chat_id' => $call_chat_id,
        'message_id' => $callback["message"]["message_id"],
    ]);

    $bot->sendMessage([
    'chat_id' => $chat_id ? $chat_id : $call_chat_id,
    'text' => $lang[$user_lang]["against_send"],
  ]);
  exit();
}

$n = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));



if($n==0 || $n==6)
{
  	$bot->sendMessage([
        'chat_id' => $chat_id_base,
        'text' => $lang[$user_lang]["stop_time"],
        'parse_mode' => 'HTML',
    ]);
  exit();
} 


//if($chat_id_base != "355699312")
//{
//  	$bot->sendMessage([
//        'chat_id' => $chat_id,
//        'text' => "Техник сазламалар алып барылмақта, тез арада бот қайта иске туседи.",
//        'parse_mode' => 'HTML',
//    ]);
//  exit();
//}

$time = date("H");
if($time<=7 || $time>=17)
{
  	$bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["stop_time"],
        'parse_mode' => 'HTML',
    ]);
  exit();
}


if($text == "/start"){
  
  if(!$tg_user)
  {
    // $data = $db->escapeString(0); // Escape any input before insert
    // $db->insert('users',array('tg_id'=>$chat_id,'map'=>0, 'username'=>$username, 'first_name'=>$ism));

    BotUser::insert([
        'bot_id' => $botModel->id,
        'user_id' => $chat_id,
        'username' => $username ? $username : "null",
        'first_name' => $ism,
        'last_name' => $ism,
        'map' => 0,
        'lang' => 'qar',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["start"],
        'parse_mode' => 'HTML',
        'reply_markup' => $inline_lang_key
    ]);
    exit();
  }
  else
  {
    // $db->update('users',array('map'=>0, 'username'=>$username, 'first_name'=>$ism), "tg_id=".$chat_id);
    $bot_user = BotUser::where('user_id', $chat_id)->first();

    $bot_user->update(
        [
            'bot_id' => $botModel->id,
            'username' => $username ? $username : 'null',
            'first_name' => $ism,
            'last_name' => $ism,
            'map' => 0,  
            'updated_at' => date('Y-m-d H:i:s'),
        ], ['user_id' => $chat_id]
    );

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["start"],
        'parse_mode' => 'HTML',
        'reply_markup' => $inline_lang_key
    ]);

    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->delete();
    $tg_user->update(['map'=>0], ['user_id'=>$call_chat_id]);
    exit();
  }
}


if(($call_data == 'Русский' || $call_data == 'Ўзбек' || $call_data == 'Қарақалпақ') && $map==0){
    if($call_data == 'Русский')
    {
        $tg_user->update(['lang' => 'ru'], ['user_id' => $chat_id_base]);
        $user_lang = 'ru';
    }
    if($call_data == 'Ўзбек')
    {
        $tg_user->update(['lang' => 'uz'], ['user_id' => $call_chat_id]);
        $user_lang = 'uz';
    }
    if($call_data == 'Қарақалпақ')
    {
        $tg_user->update(['lang' => 'qar'], ['user_id' => $call_chat_id]);
        $user_lang = 'qar';
    }

    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $call_message_id,
    ]);

    $murajaat = $lang[$user_lang]["✉️Мурәжаат қалдырыў"];

    $murajaat_key = $bot->InlineKeyboard([
    [
        ['text' => $murajaat, 'callback_data' => 'murajaat'],
    ]
]);
    $bot->sendMessage([
        'chat_id' => $chat_id_base,
        'text' => $lang[$user_lang]["Ассалаўма алейкум Ҳүрметли пуқара, бул бот арқалы Сиз, Қарақалпақстан Республикасы Жоқарғы Кеңесине өз мурәжәәтыңызды қалдырсаңыз болады.✅"],
        'parse_mode' => 'HTML',
    ]);

    $bot->sendMessage([
        'chat_id' => $chat_id_base,
        'text' => $lang[$user_lang]['Мурәжәәт қалдырыў туймесин басың🔽'],
        'parse_mode' => 'HTML',
        'reply_markup' => $murajaat_key
    ]);

    exit();
}



if($call_data == 'murajaat' || $text == $murajaat){

    if ($chat_id) {
        $chat_id = $chat_id;
    }
    else
    {
        $chat_id = $call_chat_id;
    }

    $bot->deleteMessage([
        'chat_id' => $chat_id,
        'message_id' => $call_message_id,
    ]);
    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["Фамилия атыңызды киритиң 👤"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard_cancel
    ]);
    // $db->update('users',array('map'=>1), "tg_id=$chat_id");
    $tg_user->update(['map'=>1], ['user_id'=>$chat_id]);
    exit();
}

if($text == $cancel || $call_data == 'canceled'){
    if ($chat_id) {
        $chat_id = $chat_id;
    }else{
        $chat_id = $call_chat_id;
    }
    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["cancelled"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard
    ]);

    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->delete();
    $tg_user->update(['map'=>0], ['user_id'=>$call_chat_id]);
    $map=0;
    exit();
}

if($text && $map=="1"){
    // фамилия аты validation
    if(count(preg_split('/\s+/', $text)) >= 2 && count(preg_split('/\s+/', $text)) <= 5){
        $appeal = Appeal::insert([
            'bot_user_id' => $tg_user->id,
            'fullname' => $text,
            'status'=>'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $bot->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Кайсы районда жасайсыз?📍",
            'parse_mode' => 'HTML',
            'reply_markup' => $rayon_keyboard
        ]);
    
        $tg_user->update(['map'=>'rayon'], ['user_id'=>$chat_id]);
        exit();
    }else{
        $bot->sendMessage([
            'chat_id' => $chat_id,
            'text' => $lang[$user_lang]["Фамилия атыңызды киритиң 👤"],
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard_cancel
        ]);
        exit();
    }
}

if($map=="rayon" && $call_data){

    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $call_message_id,
    ]);
    
    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['rayon' => $call_data]);

    $rayons = [
        "Амударё тумани" => [
            "Амир Темир ОФЙ",
            "Ўрта қалъа ОФЙ",
            "Тош ёп ОФЙ",
            "Арна бўйи МФЙ",
            "Боғ МФЙ",
            "Хизр эли МФЙ",
            "Қиличбой ОФЙ",
            "Беш овул МФЙ",
            "Тош қалъа МФЙ",
            "Аёқчи МФЙ",
            "Юқори қишлоқ МФЙ",
            "Холимбег ОФЙ",
            "Хитой ОФЙ",
            "Намуна МФЙ",
            "Тор ёп МФЙ",
            "Куюк кўпир ОФЙ",
            "Жумур овул МФЙ",
            "Тўлқин ОФЙ",
            "Оқ олтин ОФЙ",
            "Чойкўл ОФЙ",
            "Беш том МФЙ",
            "Қангли ОФЙ",
            "Қипчоқ ШФЙ",
            "Қум ёп МФЙ",
            "Дўрман ОФЙ",
            "Қораман МФЙ",
            "Бўз солма МФЙ",
            "Бўз ёп ОФЙ",
            "Ўзбекистон МФЙ",
            "Жумуртов ШФЙ",
            "Қизилчоли МФЙ",
            "З.М.Бобур номли ОФЙ",
            "Босув МФЙ",
            "Дарё бўйи МФЙ",
            "Қипчоқ ОФЙ",
            "Уйшин МФЙ",
            "Назархон ОФЙ",
            "Беруний МФЙ",
            "Навоий МФЙ",
            "Бўстон МФЙ",
            "Ойбек номли МФЙ",
            "Чордара МФЙ",
            "Олмазор МФЙ",
            "Дурунки МФЙ",
            "Гулзор МФЙ",
            "Бой овул МФЙ",
            "Дўстлик МФЙ",
            "Янгиобод МФЙ",
            "Фаровон МФЙ",
        ],
        "Беруний тумани" =>[
            "Тўқимачи МФЙ",
            "Навоий МФЙ",
            "Хоразм МФЙ",
            "Дўстлик МФЙ",
            "Янгиобод МФЙ",
            "Қият МФЙ",
            "Марказий МФЙ",
            "Шаббоз МФЙ",
            "У.Жуманиязов МФЙ",
            "Бирлик МФЙ",
            "Истиқлол МФЙ",
            "Наврўз МФЙ",
            "Саркоп ОФЙ",
            "Лолазор МФЙ",
            "Палваш МФЙ",
            "Бунёдкор МФЙ",
            "Жайхун МФЙ",
            "Саройкўл МФЙ",
            "Шаббоз ОФЙ",
            "Пахтакор МФЙ",
            "Оби Хаёт МФЙ",
            "Олтинсой ОФЙ",
            "Гулистон МФЙ",
            "Дўстлик ОФЙ",
            "Қизилқалъа ОФЙ",
            "Қангшартол МФЙ",
            "Беруний ОФЙ",
            "Бийбазар ОФЙ",
            "Мустақиллик МФЙ",
            "Найман МФЙ",
            "Тинчлик ОФЙ",
            "Озод ОФЙ",
            "Абай ОФЙ",
            "Махтумкули ОФЙ",
            "Бўстон МФЙ",
            "Навоий ОФЙ",
            "Турон МФЙ",
            "Ибн Сино МФЙ",
            "Шимом ОФЙ",
            "Амир Темур МФЙ",
        ],
        "Бўзатов тумани" =>[
            "Бўзатов ШФЙ",
            "Қусханатов ОФЙ",
            "Аспантай ОФЙ",
            "Эркиндарё ОФЙ",
            "Кўк сув ОФЙ",
        ],
        "Кегейли тумани" =>[
            "Жузим баг ОФЙ",
            "Ийшан кала ОФЙ",
            "Жалпак жап ОФЙ",
            "Кокозек ОФЙ",
            "Кумшунгул ОФЙ",
            "Гужим терек МФЙ",
            "Халкабад МФЙ",
            "Бахытлы МФЙ",
            "Куяшлы МФЙ",
            "Абад ОФЙ",
            "Жанабазар ОФЙ",
            "Актуба ОФЙ",
            "Маденият МФЙ",
            "Нурлы бостан МФЙ",
            "Жылуан жап МФЙ",
            "Абат макан МФЙ",
        ],
        "Қонликўл тумани"=>[
            "Бескўпир ОФЙ",
            "Наврўз ОФЙ",
            "Қонликўл ОФЙ",
            "Жаңа қала ОФЙ",
            "Бўстон ОФЙ",
            "Маденият МФЙ",
            "Қосжап ОФЙ",
            "Жайхун МФЙ",
            "Дўстлик МФЙ",
            "Арзымбетқум ОФЙ",
            "Қонликўл ШФЙ",
        ],
        "Қораўзак тумани"=>[
            "Койбак ОФЙ",
            "Кораузак ОФЙ",
            "А.Досназаров ОФЙ",
            "Есимузак ОФЙ",
            "С.Камалов ОФЙ",
            "Куралпа ОФЙ",
            "Бердах ОФЙ",
            "Маденият ОФЙ",
            "Есим МФЙ",
            "Кораузак ШФЙ",
            "Ата макан МФЙ",
            "Кутлы макан МФЙ",
            "Гарезсизлик гузары МФЙ",
        ],
        "Қўнғирот тумани"=>[
            "Тарақли МФЙ",
            "Қумбиз МФЙ",
            "Бердақ МФЙ",
            "Жинишке МФЙ",
            "Алтинкул ШФЙ",
            "Хан жап МФЙ",
            "Моншақли МФЙ",
            "Бостан МФЙ",
            "Турон МФЙ",
            "Туркистан МФЙ",
            "Қўнғирот ОФЙ",
            "Ўрнек ОФЙ",
            "Саноат МФЙ",
            "Олмазор МФЙ",
            "Мийнетабат ОФЙ",
            "Қангли ОФЙ",
            "Хоразм ОФЙ",
            "Қипшақ ОФЙ",
            "Раушан ОФЙ",
            "Қирқ қиз ШФЙ",
            "Қаратал МФЙ",
            "Таллиқ МФЙ",
            "Суенли ОФЙ",
            "Темир жол МФЙ",
            "Кўкдарё ОФЙ",
            "Гулобод МФЙ",
            "Навоий МФЙ",
            "Елабад ШФЙ",
            "Қонырат МФЙ",
            "Хаким ата МФЙ",
            "Ажинияз ОФЙ",
            "Минжарған МФЙ",
            "Азатлиқ МФЙ",
            "Киет ОФЙ",
            "Устирт ОФЙ",
            "Қорақалпоғистон ШФЙ",
            "Жаслиқ ШФЙ",
            "Адебият ОФЙ",
            "Қашы МФЙ",
        ],
        "Мўйноқ тумани"=>[
            "Жайхун МФЙ",
            "Арал МФЙ",
            "Мойнақ МФЙ",
            "Таллы өзек МФЙ",
            "Дослық МФЙ",
            "Учсай ОФЙ",
            "Тик-өзек ОФЙ",
            "Бозатаў ОФЙ",
            "Мадели ОФЙ",
            "Ҳаким-ата ОФЙ",
            "Қызылжар ОФЙ",
            "Қазақдарья ОФЙ",
        ],
        "Нукус тумани"=>[
            "Тўктов МФЙ",
            "Ақтерек МФЙ",
            "Кердер ОФЙ",
            "Бақаншақли ОФЙ",
            "Қутанкўл МФЙ",
            "Тақиркўл ОФЙ",
            "Арбаши ОФЙ",
            "Кирантов ОФЙ",
            "Саманбай ОФЙ",
            "Ақманғит ШФЙ",
        ],
        "Нукус шаҳри"=> [
            "Дарбент",
            "Наупир",
            "Жеке терек",
            "Гузар",
            "Жайхун",
            "Жана базар",
            "Жипек жоли",
            "Наукан баг",
            "Қаратаў",
            "Бес тобе",
            "Берекет",
            "Наурыз",
            "Таслак",
            "Ата макан",
            "Аманлык гузары",
            "Узын кол",
            "Айдын жол",
            "Кутлы коныс",
            "Кутлы макан",
            "Алланияз Кахарман",
            "Ели абат",
            "Сарбиназ",
            "Шымбай шайхана",
            "Тунгыш коныс",
            "Нур",
            "Ватанпарвар",
            "Ак отау",
            "Орнек",
            "Гарезсизлик",
            "Курылысшы",
            "Кок озек",
            "Гулзар",
            "Байтерек",
            "Алтын жагыс",
            "Амударья МФЙ",
            "Ақ  жағыс МФЙ",
            "Қумбыз ауыл МФЙ",
            "Темир жол МФЙ",
            "Жуазшы",
            "Наубахар",
            "Қызыл қум",
            "Жолшылар",
            "Алмазар МФЙ",
            "Шымбай гузары МФЙ",
            "Шығыс МФЙ",
            "Саманбай МФЙ",
            "Ҳаўа жолы",
            "Дослык гузары",
            "Ботаника боғи",
            "Халықлар дослығы",
            "Шайырлар овули",
            "Кум ауыл",
            "Дослық",
            "Қос кол",
            "Бакшылык",
            "Туран",
            "Боз ауыл",
            "Теле орай",
            "Жийдели байсын",
            "Тынышлық",
            "Қосбулақ",
            "Анасай",
            "Каттагар",
            "Гоне кала",
        ],
        "Тахиатош тумани"=> [
            "Дўстлик МФЙ",
            "Нурли Келажак",
            "Найманкўл ОФЙ",
            "Кенегес ОФЙ",
            "Ойдин йўл МФЙ",
            "Абат макан МФЙ",
            "Шамчироқ МФЙ",
            "Қушчилик МФЙ",
            "Сарайкўл ОФЙ",
            "Жайхун МФЙ",
            "Марказий МФЙ",
            "Тахиатош МФЙ",
            "Халқлар дўстлиги МФЙ",
        ],
        "Тахтакўпир туман" => [
            "Тахтакупир ШФЙ",
            "Гарезсизлик МФЙ",
            "Атакол ОФЙ",
            "Дауир МФЙ",
            "А.Адилов ОФЙ",
            "Айдын жол МФЙ",
            "Қараой ОФЙ",
            "Ўзбекистон МФЙ",
            "Даўқара ОФЙ",
            "Қаратерен МФЙ",
            "Белтаў ОФЙ",
            "Қоӊыраткөл ОФЙ",
            "Мулик ОФЙ",
            "Даўытсай МФЙ",
            "Жанадарья ОФЙ",
            "Маржанкол МФЙ",
            "Қоструба МФЙ",
        ],
        "Тўрткўл тумани"=>[
            "Наврўз МФЙ",
            "Ғалаба МФЙ",
            "Мустақиллик МФЙ",
            "Гулистон МФЙ",
            "Дўстлик МФЙ",
            "Беруний МФЙ",
            "Ибн-Сино МФЙ",
            "Навоий МФЙ",
            "Ёшлик МФЙ",
            "Туркистон МФЙ",
            "Тўрткўл МФЙ",
            "Марказобод МФЙ",
            "Боғёп МФЙ",
            "Ўзбекистон МФЙ",
            "Жайхун МФЙ",
            "Истиқлол МФЙ",
            "Шўрахон ОФЙ",
            "Тинчлик МФЙ",
            "Аккамиш ОФЙ",
            "Оқбошли ОФЙ",
            "Уллубоғ ОФЙ",
            "Пахтачи ОФЙ",
            "Отаюрт ОФЙ",
            "Кўна-Тўрткўл ОФЙ",
            "Анҳорли МФЙ",
            "Шодлик МФЙ",
            "Қумбосган ОФЙ",
            "Ёнбошқалъа ОФЙ",
            "Кўкча ОФЙ",
            "Пахтаобод ОФЙ",
            "Калтаминор ОФЙ",
            "Атауба ОФЙ",
            "Ўзбекистон ОФЙ",
            "Машъал МФЙ",
            "Тошкент МФЙ",
            "Янгиобод МФЙ",
            "Тозабоғёп ОФЙ ",
        ],
        "Хўжайли тумани"=>[
            "Байтерек МФЙ",
            "Жузимзар МФЙ",
            "Тинчлик МФЙ",
            "Кун нури МФЙ",
            "Обод МФЙ",
            "Муртазабий МФЙ",
            "Таскўпир МФЙ",
            "Маденият МФЙ",
            "Нурлы жол МФЙ",
            "Қырқыншы МФЙ",
            "Суенли МФЙ",
            "Парвоз МФЙ",
            "Қумбыз МФЙ",
            "Шағалакўл МФЙ",
            "Тутзар МПЖ",
            "Бунёдкор МПЖ",
            "Навруз МФЙ",
            "Жан Қўнғирот МФЙ",
            "Жайхун ШФЙ",
            "Амударё ОФЙ",
            "Жана жап ОФЙ",
            "Кулоб ОФЙ",
            "Қумжыққын ОФЙ",
            "Мустақиллик ОФЙ",
            "Саманкўл ОФЙ",
            "Сарышунгил ОФЙ",
        ],
        "Чимбой тумани"=>[
            "Бердак МФЙ",
            "Дослык МФЙ",
            "Кокши кала МФЙ",
            "Костерек ОФЙ",
            "Кенес ОФЙ",
            "Шахтемир МФЙ",
            "Гулистан МФЙ",
            "Конши МФЙ",
            "Оржап МФЙ",
            "Жипек жолы МФЙ",
            "Майжап ОФЙ",
            "Пашентов ОФЙ",
            "Гужимли МФЙ",
            "Абат макан МФЙ",
            "Темир жол МФЙ",
            "Кара кол МФЙ",
            "Тазажол ОФЙ",
            "Бахытлы ОФЙ",
            "Таг жап ОФЙ",
            "Таз гара ОФЙ",
            "Кызы озек ОФЙ",
            "Камыс арык ОФЙ",
        ],
        "Шўманой тумани"=>[
            "Мамый ОФЙ",
            "Моншақлы МФЙ",
            "Айбуйир МФЙ",
            "Тазабазар МФЙ",
            "Сарманбайкол ОФЙ",
            "Маденият МФЙ",
            "Карабайлы МФЙ",
            "Наўрыз МФЙ",
            "Кетенлер ОФЙ",
            "Бегжап ОФЙ",
            "Бирлешик ОФЙ",
            "Дийханабад",
            "Ак жап ОФЙ",
        ],
        "Элликқалъа тумани"=>[
            "Ибн Сино МФЙ",
            "Аёзқалъа МФЙ",
            "Дўстлик ОФЙ",
            "Шарқ Юлдузи ОФЙ",
            "Коинот МФЙ",
            "Ифтихор МФЙ",
            "Абай МФЙ",
            "Ихлос МФЙ",
            "Думанқалъа МФЙ",
            "Тоза Боғ ОФЙ",
            "Навбаҳор МФЙ",
            "Жасорат МФЙ",
            "Бўстон МФЙ",
            "Тупроққалъа МФЙ",
            "Қаватқалъа МФЙ",
            "Қизилқум ОФЙ",
            "Чуқурқақ МФЙ",
            "Гулистон ОФЙ",
            "Навоий ОФЙ",
            "Кичик Гулдурсун МФЙ",
            "Ақчакўл ОФЙ",
            "Иқбол МФЙ",
            "Элликқалъа ОФЙ",
            "Чўпон МФЙ",
            "Қиличиноқ ОФЙ",
            "Сарабий ОФЙ",
            "Пахтачи МФЙ",
            "Қирққизобод ОФЙ",
            "Оқ Олтин МФЙ",
            "Янги Ўзбекистон МФЙ",
            "Тошкент МФЙ",
            "А.Навоий МФЙ",
            "Қошқўра МФЙ",
            "Истиқлол МФЙ",
            "Амиробод ОФЙ",
            "Гулдурсун ОФЙ",
            "Сахтиён ШФЙ",
        ],
    ];

    $quarter_keyboard=[];
    $length = count($rayons[$call_data]);
    for($i=0; $i<$length; $i++){
        if($i%2==0){
            $quarter_keyboard[] = [['text' => $rayons[$call_data][$i], 'callback_data' => $rayons[$call_data][$i]]];
        }else{
            $quarter_keyboard[count($quarter_keyboard)-1][] = ['text' => $rayons[$call_data][$i], 'callback_data' => $rayons[$call_data][$i]];
        }
    }
    $rayons_keyboard = $bot->InlineKeyboard($quarter_keyboard);
    $bot->sendMessage([
        'chat_id'=>$call_chat_id,
        'text'=>"*{$call_data}* қайсы маҳалледенсиз?",
        'parse_mode'=>'markdown',
        'reply_markup'=>$rayons_keyboard
    ]);
   
    $tg_user->update(['map'=>"quarter"], ['user_id'=>$call_chat_id]);
    exit();
}

if($map=="quarter" && $call_data){



    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $call_message_id,
    ]);

    
    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['quarter' => $call_data]);

    $bot->sendMessage([
        'chat_id' => $call_chat_id,
        'text' => $lang[$user_lang]["Мәнзилиңизди киритиң 🏢"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard_cancel
    ]);
    $tg_user->update(['map'=>2], ['user_id'=>$call_chat_id]);
    exit();
}

if($text && $map=="2"){
    
    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['address'=>$text]);

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["Телефон номериңизди киритиң 📞☎️"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard_cancel
    ]);
    $tg_user->update(['map'=>3], ['user_id'=>$chat_id]);

    exit();
}

if($text && $map=="3"){

    // validate phone number
    if(preg_match('/^\+998\d{9}$/', $text)){
        Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['phone'=>$text]);
        $bot->sendMessage([
            'chat_id' => $chat_id,
            'text' => $lang[$user_lang]["Мурәжәәтинизди киритиң 📝"],
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard_cancel
        ]);
        $tg_user->update(['map'=>4], ['user_id'=>$chat_id]);
    }else{
        $bot->sendMessage([
            'chat_id' => $chat_id,
            'text' => $lang[$user_lang]["Телефон номериңизди киритиң 📞☎️"] . " +998xxxxxxxxx",
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard_cancel
        ]);
        exit();
    }

    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['phone'=>$text]);
    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["Мурәжәәт мазмунын киритиң 📨"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard_cancel
    ]);
    $tg_user->update(['map'=>4], ['user_id'=>$chat_id]);
    exit();
}


if($text && $map=="4"){
  
    if(count(preg_split('/\s+/', $text)) > 100)
      {
          $bot->sendMessage([
              'chat_id' => $chat_id,
              'text' => "Илтимас мүрәжат мазмунын қайталдан киритиң, 50 сөзден көп болмаўы керек",
              'parse_mode' => 'HTML',
              'reply_markup' => $keyboard_cancel
          ]);
          exit();
      }


    if(count(preg_split('/\s+/', $text)) >= 5)
    {
        Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['text'=>$text]);
        $bot->sendMessage([
            'chat_id' => $chat_id,
            'text' => $lang[$user_lang]["send_file?"],
            'parse_mode' => 'HTML',
            'reply_markup' => $key_file
        ]);
        $tg_user->update(['map'=>-99], ['user_id'=>$chat_id]);
        exit();
    }
    else
    {
        $bot->sendMessage([
            'chat_id' => $chat_id,
            'text' => "Мурәжәәт толық түрде киритиң 📝",
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard_cancel
        ]);
        exit();
    }
    
}

if($call_data && $map=="-99"){
    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $call_message_id,
    ]);

    if ($call_data == 'files_yes') {
        $bot->sendMessage([
            'chat_id' => $call_chat_id,
            'text' => $lang[$user_lang]["send_file"],
            'parse_mode' => 'HTML',
        ]);  
        $tg_user->update(['map'=>90], ['user_id'=>$call_chat_id]);
    }

    if ($call_data == 'no_files') {
        $res_2 = Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->first();
    
        $fullname =  $res_2['fullname'] ? $res_2['fullname'] : 'joq';
        $address =   $res_2['address'] ? $res_2['rayon'] . ", ". $res_2['quarter'] . ", ". $res_2['address'] : 'Address';
        $phone = $res_2['phone'] ? $res_2['phone'] : 'phone';
        $text_m = $lang[$user_lang]["appeal"] . "\n" . $res_2['text'] ? $res_2['text'] : '? ? ?';

        $l_fullname = $lang[$user_lang]["fullname"];
        $l_address = $lang[$user_lang]["address"];
        $l_phone = $lang[$user_lang]["phone"];
        $l_appeal = $lang[$user_lang]["appeal"];

        $anketa = "<b>$l_fullname</b> $fullname \n<b>$l_address</b>$address \n<b>$l_phone</b>$phone \n<b>$l_appeal</b> \n$text_m";

        $bot->sendMessage([
            'chat_id' => $call_chat_id,
            'text' => $anketa,
            'parse_mode' => 'HTML',
            'reply_markup' => $key
        ]);
        $tg_user->update(['map'=>99], ['user_id'=>$call_chat_id]);
    }
}


if (($photo || $video) && $map=="90") {

    $bot->sendMessage([
        'chat_id' => $call_chat_id,
        'text' => sizeof($photo),
        'parse_mode' => 'HTML',
        'reply_markup' => $key
    ]);

    if ($photo) {
        $count = sizeof($photo) - 1;
        $file = $photo[$count - 1]['file_id'];
        $file_type = "photo";
    }
    if ($video) {
        $file = $video['file_id'];
        $file_type = "video";
    }

    $res_2 = Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->first();
  
    $fullname = $res_2['fullname'] ? $res_2['fullname'] : 'joaq';
    $address = $res_2['address'] ? $res_2['rayon'] . "," . $res_2['quarter'] . "," . $res_2['address'] : 'Address';
    $phone = $res_2['phone'] ? $res_2['phone'] : 'phone';
    $text_m = $res_2['text'] ? $res_2['text'] : '? ? ?';

    $l_fullname = $lang[$user_lang]["fullname"];
    $l_address = $lang[$user_lang]["address"];
    $l_phone = $lang[$user_lang]["phone"];
    $l_appeal = $lang[$user_lang]["appeal"];

    $anketa = "<b>$l_fullname</b> $fullname \n<b>$l_address</b>$address \n<b>$l_phone</b>$phone \n<b>$l_appeal</b> \n$text_m";

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $anketa,
        'parse_mode' => 'HTML',
        'reply_markup' => $key,
        "reply_to_message_id" => $message_id
    ]);
    // $db->update('murajaat_wait',array('file_id'=>$file, 'file_type'=>$file_type), "tg_id=$chat_id");
    // $db->update('users',array('map'=>"99"), "tg_id=$chat_id");
    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['file_id'=>$file, 'file_type'=>$file_type]);
    $tg_user->update(['map'=>99], ['user_id'=>$chat_id]);
}

if($map=="99" && $call_data == 'accepted'){
    // $db->select('murajaat_wait','*',NULL,"tg_id=$call_chat_id"); 

    $res_2 = Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->first();
  
    $fullname = $res_2['fullname'] ? $res_2['fullname'] : '???';
    
    $address = $res_2['address'] ? $res_2['rayon'] . ", ". $res_2['quarter'] . ", ". $res_2['address'] : 'Address';
    $phone = $res_2['phone'] ? $res_2['phone'] : '???';
    $text_m = $res_2['text'] ? $res_2['text'] : '? ? ?';
    $file = $res_2['file_id'] ? $res_2['file_id'] : null;
    $file_type = $res_2['file_type'] ? $res_2['file_type'] : null;
    $date = date('d.m.Y');

    $l_fullname = $lang[$user_lang]["fullname"];
    $l_address = $lang[$user_lang]["address"];
    $l_phone = $lang[$user_lang]["phone"];
    $l_appeal = $lang[$user_lang]["appeal"];
    $l_new_appeal = $lang[$user_lang]["new_appeal"];
    $l_profile = $lang[$user_lang]["profile"];
    $id = "🆔 #" . $res_2->id;

    $anketa = "$id \n<b>$l_fullname</b> $fullname \n<b>$l_address</b>$address \n<b>$l_phone</b>$phone \n<b>$l_appeal</b> \n$text_m";

    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $call_message_id,
    ]);

    $msg = $bot->sendMessage([
        'chat_id' => $call_chat_id,
        'text' => $anketa,
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard
    ]);
    $bot->sendMessage([
        'chat_id' => $call_chat_id,
        'text' => $lang[$user_lang]["Рахмет Сизиң мурәжәәтиңиз қабылланды тез арада тийисли шөлкемлер арқалы жуўап аласыз ! ✅ ✅"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard
    ]);

    $bot->sendMessage([
        'chat_id' => $kanal_chat_id,
        'text' => "$l_new_appeal, <a href='tg://user?id=$call_chat_id'>$l_profile</a>\n" . $anketa,
        'parse_mode' => 'HTML',
    ]);

    if ($file) 
    {
        if($file_type == "photo")
        {
            $bot->sendPhoto([
                "chat_id" => $kanal_chat_id,
                "photo" => $file,
            ]);
        }
        if($file_type == "video")
        {
            $bot->sendVideo([
                "chat_id" => $kanal_chat_id,
                "video" => $file,
            ]);
        }
    }

    $msg = json_decode(json_encode($msg, JSON_PRETTY_PRINT), true);
    $msg=$msg["result"]["message_id"];

    $tg_user->update(['map'=>0], ['user_id'=>$call_chat_id]);
    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->update(['status'=>'paid', 'msg_id'=>$msg]);
}

if($call_data == 'good'){

    $reply = Reply::where('msg_id', $callback["message"]["message_id"])->where('bot_id', $botModel->bot_id)->first();
    $reply->update([
        "status" => "good"
    ], ['msg_id'=>$callback["message"]["reply_to_message"]["message_id"], 'bot_id', $botModel->bot_id]);

    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $callback["message"]["message_id"],
    ]);

    $bot->sendMessage([
    'chat_id' => $chat_id ? $chat_id : $call_chat_id,
    'text' => $lang[$user_lang]["good_send"],
  ]);
}

if($call_data == 'against'){
    $reply = Reply::where('msg_id', $callback["message"]["message_id"])->where('bot_id', $botModel->bot_id)->first();
    $reply->update([
        "status" => "against"
    ], ['msg_id'=>$callback["message"]["reply_to_message"]["message_id"], 'bot_id', $botModel->bot_id]);

    $bot->deleteMessage([
        'chat_id' => $call_chat_id,
        'message_id' => $callback["message"]["message_id"],
    ]);

    $bot->sendMessage([
    'chat_id' => $chat_id ? $chat_id : $call_chat_id,
    'text' => $lang[$user_lang]["against_send"],
  ]);
}

