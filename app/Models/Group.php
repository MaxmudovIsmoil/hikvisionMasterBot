<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'count',
        'level',
        'ball',
        'status',
        'phone',
        'chatId',
        'creator_id',
        'updater_id'
    ];

    public function detail()
    {
        return $this->hasMany(GroupDetail::class, 'group_id', 'id')
            ->where('deleted_at', null);
    }

    public function user()
    {
        return $this->hasMany(GroupUser::class, 'group_id', 'id');
    }
}
