<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('botanical_family'); // لكسر دورة الآفات
            $table->enum('water_demand', ['low', 'medium', 'high']);
            $table->enum('profitability', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_nitrogen_fixer')->default(false);
            $table->boolean('is_cover_crop')->default(false);
            $table->enum('root_depth', ['shallow', 'medium', 'deep']);
            $table->string('forage_or_market_value');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('crops');
    }
};
