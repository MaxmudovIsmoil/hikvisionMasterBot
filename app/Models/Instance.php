<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_ru',
//        'name_en',
//        'name_uz',
        'status',
        'time_line',
        'deleted_at',
    ];
}
