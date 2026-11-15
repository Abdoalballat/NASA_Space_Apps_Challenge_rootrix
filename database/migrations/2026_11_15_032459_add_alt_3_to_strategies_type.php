<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */

public function up(): void
{
    DB::statement("ALTER TABLE strategies MODIFY strategy_type ENUM('current','alt_1','alt_2','alt_3') NOT NULL");
}

public function down(): void
{
    DB::statement("ALTER TABLE strategies MODIFY strategy_type ENUM('current','alt_1','alt_2') NOT NULL");
}
};
