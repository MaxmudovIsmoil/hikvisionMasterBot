<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'group_id',
        'key',
        'val',
        'status',
        'creator_id',
        'updater_id',
        'deleter_id'
    ];

}
