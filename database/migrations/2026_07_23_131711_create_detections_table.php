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
        Schema::create('detections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('police_unit_id')->constrained()->onDelete('cascade');
            $table->string('location')->nullable();

            $table->string('detected_model')->nullable();
            $table->string('detected_color')->nullable();
            $table->string('detected_type')->nullable();
            $table->string('detected_plate_number')->nullable();

            $table->double('confidence')->nullable();
            $table->enum('match_status', ['match', 'no_match'])->nullable();

            $table->datetimes('detected_at')->nullable();
            $table->string('vehicle_image_path')->nullable();
            $table->string('plate_image_path')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detections');
    }
};
