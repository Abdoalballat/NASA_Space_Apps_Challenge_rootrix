<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $guarded = [];
    protected $fillable = [
    'farm_id',
    'avg_temp_anomaly',
    'precipitation_mm',
    'soil_moisture_index',
    'ndvi_vegetation_stress',
    'bare_soil_months'
];



    // تحويل حقل الأشهر العارية من JSON في الداتابيز إلى مصفوفة (Array) في الكود تلقائياً
    protected $casts = [
        'bare_soil_months' => 'array',
    ];

    // المزرعة صاحبة التقرير
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    // الاستراتيجيات الثلاثة المرتبطة بهذا التقرير
    public function strategies(): HasMany
    {
        return $this->hasMany(Strategy::class);
    }
}