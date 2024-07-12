<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'blanka_photo',
        'photo_id',
    ];

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
