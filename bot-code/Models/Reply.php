<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'bot_id',
        'appeal_id',
        'msg_id',
        'text',
        'status',
        'user_text'
    ];

    public function appeal()
    {
        return $this->belongsTo(Appeal::class);
    }
}
