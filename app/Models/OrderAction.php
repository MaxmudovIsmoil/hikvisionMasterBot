<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'user_id',
        'instance_id',
        'status',
        'time_signed',
        'comment',
        'stage',
    ];

    public $timestamps = true;

    protected $casts = [
        'status' => OrderStatus::class
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function instance()
    {
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }

}
