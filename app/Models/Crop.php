<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crop extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'botanical_family',
        'water_demand',
        'is_nitrogen_fixer',
        'is_cover_crop',
        'root_depth',
        'forage_or_market_value',
        'profitability',
    ];

    protected $casts = [
        'is_nitrogen_fixer' => 'boolean',
        'is_cover_crop'     => 'boolean',
    ];

    // ده السطر الناقص: بيخلّي display_name يطلع مع المحصول لما يتحول JSON
    protected $appends = ['display_name'];

    public function getDisplayNameAttribute(): string
    {
        return $this->attributes['name_ar'] ?? $this->attributes['name'] ?? '';
    }

    // المزارع التي تزرع هذا المحصول حالياً
    public function farms(): HasMany
    {
        return $this->hasMany(Farm::class, 'current_crop_id');
    }

    // الاستراتيجيات التي تقترح هذا المحصول
    public function strategies(): BelongsToMany
    {
        return $this->belongsToMany(Strategy::class, 'strategy_crops')
                    ->withPivot('sequence_order')
                    ->withTimestamps();
    }
}