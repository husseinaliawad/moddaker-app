<?php

namespace App\Models;

use App\Models\Concerns\InteractsWithTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, InteractsWithTranslations;

    protected $fillable = [
        'slug',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getNameAttribute(): string
    {
        return $this->translation()?->name ?? $this->slug;
    }
}
