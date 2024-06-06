<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_instance_id',
        'instance_id',
        'stage',
        'status',
    ];

    public $timestamps = false;

//    protected $casts = array(
//        'status' => OrderStatus::class
//    );

    public function instance()
    {
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }

    public function another_instance()
    {
        return $this->hasMany(UserInstance::class, 'instance_id', 'instance_id')
            ->leftJoin('users', 'users.id', '=', 'user_instances.user_id')
            ->whereNull('users.deleted_at')
            ->select('user_instances.*', 'users.name');
    }

    public function userInstance()
    {
        return $this->hasMany(UserInstance::class, 'instance_id', 'instance_id');
    }

}
