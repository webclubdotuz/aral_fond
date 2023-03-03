<?php

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
$botModel = Bot::where('bot_id', '1565287205')->first();

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

$chat_id_base = $chat_id ? $chat_id : $call_chat_id;


$tg_user = BotUser::where(['user_id'=>$chat_id_base, 'bot_id'=>$botModel->id])->first();
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

$bot->sendChatAction([
    'chat_id' => $chat_id ? $chat_id : $call_chat_id,
    'action' => "typing"
  ]);

// $bot->sendMessage([
//     'chat_id' => $chat_id ? $chat_id : $call_chat_id,
//     'text' => $in_data
//   ]);
// $bot->sendMessage([
//     'chat_id' => $chat_id,
//     'text' => $photo["file_id"],
//     'reply_to_message_id'=>$message_id,
//   ]);
// $bot->sendPhoto([
//     'chat_id' => $kanal_chat_id,
//     'photo' => $photo["file_id"],
//   ]);

// $bot->sendPhoto([
//     'chat_id' => $chat_id,
//     'photo' => $photo["file_id"],
//   ]);


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
    // $db->update('users',array('map'=>0), "tg_id=$chat_id");
    // $db->delete('murajaat_wait',"tg_id=$chat_id");
    Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->delete();
    $tg_user->update(['map'=>0], ['user_id'=>$call_chat_id]);
    $map=0;
    exit();
}

if($text && $map=="1"){
  
    $appeal = Appeal::insert([
        'bot_user_id' => $tg_user->id,
        'fullname' => $text,
        'status'=>'pending',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    $bot->sendMessage([
        'chat_id' => $chat_id,
        'text' => $lang[$user_lang]["Мәнзилиңизди киритиң 🏢"],
        'parse_mode' => 'HTML',
        'reply_markup' => $keyboard_cancel
    ]);
    $tg_user->update(['map'=>2], ['user_id'=>$chat_id]);
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
        $address =   $res_2['address'] ? $res_2['address'] : 'Address';
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

    if ($photo) {
        $file = $photo['file_id'];
        $file_type = "photo";
    }
    if ($video) {
        $file = $video['file_id'];
        $file_type = "video";
    }

    $res_2 = Appeal::where(['bot_user_id' => $tg_user->id, 'status'=>'pending'])->first();
  
    $fullname = $res_2['fullname'] ? $res_2['fullname'] : 'joaq';
    $address = $res_2['address'] ? $res_2['address'] : 'Address';
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
    $address = $res_2['address'] ? $res_2['address'] : '???';
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

    $anketa = "<b>$l_fullname</b> $fullname \n<b>$l_address</b>$address \n<b>$l_phone</b>$phone \n<b>$l_appeal</b> \n$text_m";

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

    // $bot->sendMessage([
    //     'chat_id' => $kanal_chat_id,
    //     'text' => "$l_new_appeal, <a href='tg://user?id=$call_chat_id'>$l_profile</a>\n" . $anketa,
    //     'parse_mode' => 'HTML',
    // ]);

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

