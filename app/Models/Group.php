<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'count',
        'level',
        'ball',
        'status',
        'creator_id',
        'updater_id'
    ];

    public function detail()
    {
        return $this->hasMany(GroupDetail::class, 'group_id', 'id')
            ->where('deleted_at', null);
    }
}
