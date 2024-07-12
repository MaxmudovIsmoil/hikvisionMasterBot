<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CategoryInstall extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_installs';

    protected $fillable = [
        'name',
        'description',
        'status',
        'creator_id',
        'updater_id',
        'deleted_at'
    ];

//    public $timestamps = false;

    public function install()
    {
        return $this->hasMany(Install::class, 'category_id', 'id');
    }
}
