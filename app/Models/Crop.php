<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Crop extends Model
{
    protected $guarded = [];
    protected $fillable = [
    'name', 
    'botanical_family', 
    'water_demand', 
    'is_nitrogen_fixer', 
    'is_cover_crop', 
    'root_depth', 
    'forage_or_market_value', 
    'profitability'
];

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