<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'installations';

    protected $fillable = [
        'category_id',
        'blanka_number',
        'area',
        'address',
        'location',
        'latitude',
        'longitude',
        'price',
        'description',
        'status',
        'creator_id',
        'updater_id',
        'deleter_id'
    ];

    public function category()
    {
        return $this->hasOne(CategoryInstallation::class, 'id', 'category_id');
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
