<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instance_id',
        'current_instance_id',
        'status', // 1-processing, 2-accepted, 3-go back, 4-declined, 5-completed
        'theme',
        'stage_count',
        'current_stage',
        'deleted_at',
    ];

   protected $casts = [
       'status' => OrderStatus::class
   ];

    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function instance()
    {
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }

    public function currentInstance()
    {
        return $this->hasOne(Instance::class, 'id', 'current_instance_id');
    }

    public function orderAction()
    {
        return $this->hasMany(OrderAction::class, 'id', 'order_id');
    }

    public function userPlan()
    {
        return $this->hasMany(UserPlan::class, 'user_id', 'user_id');
    }


}
