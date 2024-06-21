<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installation extends Model
{
    use HasFactory, SoftDeletes;

//    protected $table = 'installations';

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
        'creator_id',
        'updater_id',
        'deleter_id'
    ];

    public function category()
    {
        return $this->hasOne(CategoryInstallation::class, 'id', 'category_id');
    }
}
