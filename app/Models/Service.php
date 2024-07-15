<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

//    protected $table = 'installs';

    protected $fillable = [
        'blanka_number',
        'area',
        'name',
        'phone',
        'address',
        'location',
        'latitude',
        'longitude',
        'description',
        'comment', // admin or group stop this order
        'status',
        'creator_id',
        'updater_id',
        'deleter_id'
    ];



    public function sendGroups()
    {
        return $this->hasMany(ServiceSendGroup::class, 'service_id', 'id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

}
