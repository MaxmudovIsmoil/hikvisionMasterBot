<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupInstall extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'group_installs';

    protected $fillable = [
        'group_id',
        'install_id',
        'status',
        'deleted_at'
    ];

    public function group()
    {
        return $this->hasOne(Group::class, '', 'id');
    }
}
