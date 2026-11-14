<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('strategies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->enum('strategy_type', ['current', 'alt_1', 'alt_2']);
            $table->text('why_suggested');
            $table->text('supporting_evidence');
            $table->text('expected_benefits');
            $table->text('information_gaps');
            $table->text('local_review_risks');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('strategies');
    }
};