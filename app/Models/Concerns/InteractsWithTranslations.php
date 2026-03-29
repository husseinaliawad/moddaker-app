<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

trait InteractsWithTranslations
{
    public function translation(?string $locale = null): ?Model
    {
        $locale ??= app()->getLocale();
        $fallbackLocale = config('app.fallback_locale');

        $translations = $this->relationLoaded('translations')
            ? $this->getRelation('translations')
            : $this->translations()->get();

        return $translations->firstWhere('locale', $locale)
            ?? $translations->firstWhere('locale', $fallbackLocale)
            ?? $translations->first();
    }
}

