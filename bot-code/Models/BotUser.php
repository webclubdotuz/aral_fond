<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotUser extends Model
{
    protected $table = "bot_users";

    protected $guarded = [];

    public function bot()
    {
        return $this->belongsTo(Bot::class);
    }

    public function appeal()
    {
        return $this->belongsTo(Appeal::class);
    }

}
