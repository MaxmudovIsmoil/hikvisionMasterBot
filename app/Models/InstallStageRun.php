<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallStageRun extends Model
{
    use HasFactory;

    protected $table = 'install_stage_runs';

    protected $fillable = [
       'install_id',
       'stage',
       'text',
    ];

    public $timestamps = false;
}
