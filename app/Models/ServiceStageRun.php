<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceStageRun extends Model
{
    use HasFactory;

    protected $table = 'service_stage_runs';

    protected $fillable = [
       'service_id',
       'stage',
       'text',
    ];

    public $timestamps = false;

}
