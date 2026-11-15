<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            ['name' => 'Wheat', 'name_ar' => 'قمح', 'botanical_family' => 'Poaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'medium'],
            ['name' => 'Egyptian Clover', 'name_ar' => 'برسيم مصري', 'botanical_family' => 'Fabaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => true, 'is_cover_crop' => true, 'root_depth' => 'medium', 'forage_or_market_value' => 'Forage', 'profitability' => 'medium'],
            ['name' => 'Faba Bean', 'name_ar' => 'فول بلدي', 'botanical_family' => 'Fabaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => true, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'medium'],
            ['name' => 'Sugar Beet', 'name_ar' => 'بنجر السكر', 'botanical_family' => 'Amaranthaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Onion', 'name_ar' => 'بصل', 'botanical_family' => 'Amaryllidaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Garlic', 'name_ar' => 'ثوم', 'botanical_family' => 'Amaryllidaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Potato', 'name_ar' => 'بطاطس', 'botanical_family' => 'Solanaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Tomato', 'name_ar' => 'طماطم', 'botanical_family' => 'Solanaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],

            // ---------------- Summer Crops ----------------
            ['name' => 'Rice', 'name_ar' => 'أرز', 'botanical_family' => 'Poaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'shallow', 'forage_or_market_value' => 'Market', 'profitability' => 'medium'],
            ['name' => 'Maize', 'name_ar' => 'ذرة شامية', 'botanical_family' => 'Poaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Dual', 'profitability' => 'medium'],
            ['name' => 'Cotton', 'name_ar' => 'قطن', 'botanical_family' => 'Malvaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Sorghum', 'name_ar' => 'ذرة رفيعة', 'botanical_family' => 'Poaceae', 'water_demand' => 'low', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Dual', 'profitability' => 'low'],
            ['name' => 'Soybean', 'name_ar' => 'فول صويا', 'botanical_family' => 'Fabaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => true, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Dual', 'profitability' => 'high'],
            ['name' => 'Peanut', 'name_ar' => 'فول سوداني', 'botanical_family' => 'Fabaceae', 'water_demand' => 'medium', 'is_nitrogen_fixer' => true, 'is_cover_crop' => false, 'root_depth' => 'medium', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],
            ['name' => 'Sesame', 'name_ar' => 'سمسم', 'botanical_family' => 'Pedaliaceae', 'water_demand' => 'low', 'is_nitrogen_fixer' => false, 'is_cover_crop' => false, 'root_depth' => 'deep', 'forage_or_market_value' => 'Market', 'profitability' => 'high'],

            // ---------------- Perennial / Reclamation Crops ----------------
            ['name' => 'Alfalfa', 'name_ar' => 'برسيم حجازي', 'botanical_family' => 'Fabaceae', 'water_demand' => 'high', 'is_nitrogen_fixer' => true, 'is_cover_crop' => true, 'root_depth' => 'deep', 'forage_or_market_value' => 'Forage', 'profitability' => 'high'],
        ];

        $now = now();
        foreach ($crops as &$crop) {
            $crop['created_at'] = $now;
            $crop['updated_at'] = $now;
        }

        DB::table('crops')->insert($crops);
    }
}