<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['name' => 'Water Conservation'],
            ['name' => 'Soil Fertility & Nitrogen Fixation'],
            ['name' => 'Erosion Control'],
            ['name' => 'Income Maximization'],
            ['name' => 'Forage Production'],
        ];

        DB::table('priorities')->insert($priorities);
    }
}
