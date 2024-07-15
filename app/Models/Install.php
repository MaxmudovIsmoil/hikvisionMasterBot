<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Install extends Model
{
    use HasFactory, SoftDeletes;

//    protected $table = 'installs';

    protected $fillable = [
        'category_id',
        'blanka_number',
        'name',
        'area',
        'address',
        'location',
        'latitude',
        'longitude',
        'price',
        'description',
        'comment', // admin or group stop this order
        'status',
        'creator_id',
        'updater_id',
        'deleter_id'
    ];

    public function category()
    {
        return $this->hasOne(CategoryInstall::class, 'id', 'category_id');
    }

    public function sendGroups()
    {
        return $this->hasMany(InstallSendGroup::class, 'install_id', 'id');
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
