<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('install_stage_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('install_id');
            $table->integer('stage')->nullable();
            $table->string('text')->nullable();
            $table->unique(['install_id', 'stage']);
            $table->foreign('install_id')
                ->references('id')
                ->on('installs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('install_stage_runs');
    }
};
