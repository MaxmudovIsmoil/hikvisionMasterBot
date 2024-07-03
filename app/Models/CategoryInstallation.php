<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CategoryInstallation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_installations';
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
        return $this->hasMany(Installation::class, 'category_id', 'id');
    }
}
