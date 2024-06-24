<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CategoryInstallation extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'category_installations';
    protected $fillable = [
        'name',
        'description',
        'status',
        'creator_id',
        'updater_id'
    ];

//    public $timestamps = false;

}
