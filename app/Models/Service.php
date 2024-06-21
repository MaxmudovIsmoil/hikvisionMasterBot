<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'blanka_number',
        'area',
        'address',
        'location',
        'latitude',
        'longitude',
        'description',
        'creator_id',
        'updater_id',
        'deleter_id'
    ];


}
