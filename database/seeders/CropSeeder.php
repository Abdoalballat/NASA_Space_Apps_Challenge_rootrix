<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // أضفنا هذا السطر

class CropSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إيقاف التحقق من المفاتيح الأجنبية مؤقتاً
        Schema::disableForeignKeyConstraints();

        // 2. مسح الجدول
        DB::table('crops')->truncate();

        // 3. إعادة تشغيل التحقق من المفاتيح الأجنبية
        Schema::enableForeignKeyConstraints();

        $crops = [
            // ---------------- Winter Crops ----------------
            ['name' => 'Wheat', 'botanical_family' => 'Poaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'medium'],
            ['name' => 'Egyptian Clover', 'botanical_family' => 'Fabaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => true, 'is_cover_crop' => true, 'root_depth' => 'medium', 'forage_or_market_value' => 'Forage', 'profitability' => 'medium'],
            ['name' => 'Faba Bean', 'botanical_family' => 'Fabaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => true, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'medium'],
            ['name' => 'Sugar Beet', 'botanical_family' => 'Amaranthaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Onion', 'botanical_family' => 'Amaryllidaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Garlic', 'botanical_family' => 'Amaryllidaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Potato', 'botanical_family' => 'Solanaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Tomato', 'botanical_family' => 'Solanaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],

            // ---------------- Summer Crops ----------------
            ['name' => 'Rice', 'botanical_family' => 'Poaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'medium'],
            ['name' => 'Maize', 'botanical_family' => 'Poaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Dual', 'profitability' => 'medium'],
            ['name' => 'Cotton', 'botanical_family' => 'Malvaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Sorghum', 'botanical_family' => 'Poaceae', 'water_demand' => 'low', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Dual', 'profitability' => 'low'],
            ['name' => 'Soybean', 'botanical_family' => 'Fabaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => true, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Dual', 'profitability' => 'high'],
            ['name' => 'Peanut', 'botanical_family' => 'Fabaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => true, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Sesame', 'botanical_family' => 'Pedaliaceae', 'water_demand' => 'low', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],

            // ---------------- Perennial / Reclamation Crops ----------------
            ['name' => 'Alfalfa', 'botanical_family' => 'Fabaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => true, 'is_cover_crop' => true, 'root_depth' => 'deep', 'forage_or_market_value' => 'Forage', 'profitability' => 'high'],
        ];

        $now = now();
        foreach ($crops as &$crop) {
            $crop['created_at'] = $now;
            $crop['updated_at'] = $now;
        }

        DB::table('crops')->insert($crops);
    }
}