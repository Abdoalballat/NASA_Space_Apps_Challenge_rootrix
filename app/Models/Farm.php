<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Farm extends Model
{
    protected $guarded = [];
    protected $fillable = [
    'session_uuid',
    'latitude',
    'longitude',
    'area',
    'irrigation_type',
    'equipment_constraints',
    'current_crop_id'
];

    // المحصول المزروع حالياً
    public function currentCrop(): BelongsTo
    {
        return $this->belongsTo(Crop::class, 'current_crop_id');
    }

    // أولويات المزارع (علاقة Many-to-Many)
    public function priorities(): BelongsToMany
    {
        return $this->belongsToMany(Priority::class);
    }

    // التقرير المناخي الخاص بالمزرعة (نجلب أحدث تقرير)
    public function report(): HasOne
    {
        return $this->hasOne(Report::class)->latest();
    }
}