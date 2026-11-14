<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Priority extends Model
{
    protected $guarded = [];
    protected $fillable = [
    'name'
];

    // المزارع التي اختارت هذه الأولوية
    public function farms(): BelongsToMany
    {
        return $this->belongsToMany(Farm::class);
    }
}