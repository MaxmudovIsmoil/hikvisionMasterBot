<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallSendGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'install_send_groups';

    protected $fillable = [
        'install_id',
        'group_id',
        'status',
    ];


    public function isntall()
    {
        return $this->hasOne(Install::class, 'id', 'install_id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }


}
