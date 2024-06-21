<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupBall extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'text',
    ];


}
