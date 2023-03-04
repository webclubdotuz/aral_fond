<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_id',
        'file_path',
        'description',
        'status',
        'type',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
