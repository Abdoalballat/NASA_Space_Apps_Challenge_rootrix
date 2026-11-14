<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Strategy extends Model
{
    protected $guarded = [];

    // التقرير المبني عليه هذه الاستراتيجية
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    // المحاصيل المقترحة في هذه الاستراتيجية (مرتبة حسب دورة الزراعة)
    public function crops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'strategy_crops')
                    ->withPivot('sequence_order') // جلب ترتيب المحصول في الدورة
                    ->orderBy('pivot_sequence_order') // ترتيب المحاصيل تلقائياً (الأول ثم الثاني..)
                    ->withTimestamps();
    }
}