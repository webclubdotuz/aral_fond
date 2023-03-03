<?php


use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $table = "appeals";

    protected $guarded = [];

    public function bot_user()
    {
        return $this->belongsTo(BotUser::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
