<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFile extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_DEFAULT = 1;
    const STATUS_UPDATE = 2;

    protected $fillable = [
        'order_id',
        'user_id',
        'file',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
