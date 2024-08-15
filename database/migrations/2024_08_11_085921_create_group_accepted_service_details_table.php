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
        Schema::create('accepted_service_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accepted_service_id');
            $table->unsignedBigInteger('service_stage_run_id'); // old
            $table->string('value')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->foreign('accepted_service_id')->references('id')->on('accepted_services')->onDelete('cascade');
            $table->foreign('service_stage_run_id')->references('id')->on('service_stage_runs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accepted_service_details');
    }
};
