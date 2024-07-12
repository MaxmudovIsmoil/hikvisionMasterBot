<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'install_id',
        'blanka_photo',
        'photo_id',
    ];

    public function install()
    {
        return $this->hasOne(Install::class, 'id', 'user_id');
    }

}
