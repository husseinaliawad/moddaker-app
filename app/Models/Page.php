<?php

namespace App\Models;

use App\Models\Concerns\InteractsWithTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory, InteractsWithTranslations;

    protected $fillable = [
        'slug',
        'template',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function getTitleAttribute(): string
    {
        return $this->translation()?->title ?? $this->slug;
    }

    public function getContentAttribute(): ?string
    {
        return $this->translation()?->content;
    }
}
