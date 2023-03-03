<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'fullname',
        'phone',
        'birthday',
        'rayon',
        'school',
        'class',
        'map',
        'is_active',
    ];

}
