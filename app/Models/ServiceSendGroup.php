<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSendGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_send_groups';

    protected $fillable = [
        'service_id',
        'group_id',
        'status',
    ];


    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
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
