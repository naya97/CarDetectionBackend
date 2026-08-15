<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('video_id')->constrained('videos')->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('track_id');

            $table->string('detected_plate_number')->nullable();
            $table->double('plate_confidence')->nullable();

            $table->string('detected_model')->nullable();
            $table->double('model_confidence')->nullable();

            $table->string('detected_type')->nullable();
            $table->double('type_confidence')->nullable();

            $table->string('detected_color')->nullable();
            $table->double('color_confidence')->nullable();

            $table->boolean('plate_match')->default(false);
            $table->boolean('color_mismatch')->default(false);
            $table->boolean('type_mismatch')->default(false);
            $table->boolean('model_mismatch')->default(false);
            $table->boolean('plate_mismatch')->default(false);

            $table->double('risk_score')->nullable();
            $table->enum('severity', ['منخفض', 'متوسط', 'عالي'])->nullable();
            $table->string('violation_type')->nullable();
            $table->text('message')->nullable();

            $table->string('vehicle_image_path')->nullable();
            $table->string('plate_image_path')->nullable();

            $table->dateTime('detected_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detections');
    }
};
