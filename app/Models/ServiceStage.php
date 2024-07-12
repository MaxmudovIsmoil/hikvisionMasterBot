<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceStage extends Model
{
    use HasFactory;

    protected $table = 'service_stages';

    protected $fillable = [
        'stage',
        'text',
    ];

    public $timestamps = false;
}
