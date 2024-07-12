<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallStage extends Model
{
    use HasFactory;

    protected $table = 'install_stages';

    protected $fillable = [
        'stage',
        'text',
    ];

    public $timestamps = false;
}
