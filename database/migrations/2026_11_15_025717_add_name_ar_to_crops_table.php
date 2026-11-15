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
    Schema::table('crops', function (Blueprint $table) {
        $table->string('name_ar')->nullable()->after('name');
    });

    // ترجمة المحاصيل الموجودة. زوّد أي محصول مش موجود هنا
    $translations = [
        'Egyptian Clover' => 'برسيم مصري',
        'Alfalfa'         => 'برسيم حجازي',
        'Soybean'         => 'فول صويا',
        'Sesame'          => 'سمسم',
        'Wheat'           => 'قمح',
        'Maize'           => 'ذرة شامية',
        'Corn'            => 'ذرة شامية',
        'Sorghum'         => 'ذرة رفيعة',
        'Rice'            => 'أرز',
        'Cotton'          => 'قطن',
        'Faba Bean'       => 'فول بلدي',
        'Barley'          => 'شعير',
        'Sugar Beet'      => 'بنجر السكر',
        'Peanut'          => 'فول سوداني',
        'Potato'          => 'بطاطس',
        'Tomato'          => 'طماطم',
        'Onion'           => 'بصل',
        'Sunflower'       => 'عباد الشمس',
        'Lentil'          => 'عدس',
        'Chickpea'        => 'حمص',
    ];

    foreach ($translations as $en => $ar) {
        DB::table('crops')->where('name', $en)->update(['name_ar' => $ar]);
    }
}

public function down(): void
{
    Schema::table('crops', fn (Blueprint $table) => $table->dropColumn('name_ar'));
}
};
