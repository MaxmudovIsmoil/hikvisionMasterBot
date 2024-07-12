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
        Schema::create('install_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('install_id');
            $table->string('blanka_photo');
            $table->string('photo');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('install_files');
    }
};
