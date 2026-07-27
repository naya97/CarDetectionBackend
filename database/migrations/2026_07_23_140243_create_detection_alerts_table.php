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
        Schema::create('detection_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detection_id')->constrained()->onDelete('cascade');
            $table->string('alert_type')->nullable();
            $table->enum('severity', ['low', 'medium', 'high'])->nullable();
            $table->string('message')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detection_alerts');
    }
};
