<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();
            $table->decimal('avg_temp_anomaly', 5, 2)->nullable();
            $table->decimal('precipitation_mm', 8, 2)->nullable();
            $table->decimal('soil_moisture_index', 5, 2)->nullable();
            $table->decimal('ndvi_vegetation_stress', 5, 2)->nullable();
            $table->json('bare_soil_months')->nullable(); // مصفوفة بالأشهر
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reports');
    }
};