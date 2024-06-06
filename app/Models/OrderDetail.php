<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    const STATUS_DEFAULT = 1;
    const STATUS_UPDATE = 2;

    protected $fillable = [
        'order_id',
        'name',
        'count',
        'pcs', // шт
        'address',
        'price_source', // taxminiy narx
        'deleted_at',
        'status',
    ];

}
