<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('original_video_path');
            $table->string('processed_video_path')->nullable();
            $table->dateTime('uploaded_at');
            $table->decimal('duration', 10, 2)->nullable();
            $table->unsignedBigInteger('size');
            $table->enum('status', ['processing', 'completed', 'failed'])->default('processing');
            $table->unsignedInteger('total_vehicles')->default(0);
            $table->unsignedInteger('total_violations')->default(0);
            $table->unsignedInteger('high_violations')->default(0);
            $table->unsignedInteger('medium_violations')->default(0);
            $table->unsignedInteger('low_violations')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
