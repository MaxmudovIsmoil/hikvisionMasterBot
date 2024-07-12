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
        Schema::create('service_stage_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->integer('stage')->nullable();
            $table->string('text')->nullable();
            $table->unique(['service_id', 'stage']);
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_stage_runs');
    }
};
