<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'phone',
        'birthday',
        'address',
        'source',
        'comment',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
