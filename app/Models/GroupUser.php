<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
        'capitan',
    ];

    public $timestamps = false;



    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
