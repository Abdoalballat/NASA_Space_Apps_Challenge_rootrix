<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_uuid')->index();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('area', 8, 2)->comment('Area in hectares or acres');
            $table->enum('irrigation_type', ['flood', 'drip', 'sprinkler', 'rainfed']);
            $table->text('equipment_constraints')->nullable();
            $table->foreignId('current_crop_id')->nullable()->constrained('crops')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('farms');
    }
};
