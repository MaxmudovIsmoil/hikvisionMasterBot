<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instance_id',
    ];

    public $timestamps = false;

    public function instance()
    {
        return $this->hasOne(Instance::class, 'id', 'instance_id')
            ->select('id', 'name_ru');
    }

    public function user_plan()
    {
        return $this->hasMany(UserPlan::class,'user_instance_id', 'instance_id')
            ->where('user_id', Auth::id())
            ->orderBy('stage', 'ASC');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
