<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elon extends Model
{
    use HasFactory;

    protected $fillable = [
        'groupIds',
        'message',
    ];
}
