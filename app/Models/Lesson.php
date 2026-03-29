<?php

namespace App\Models;

use App\Models\Concerns\InteractsWithTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory, InteractsWithTranslations;

    protected $fillable = [
        'course_id',
        'slug',
        'order_column',
        'duration_minutes',
        'video_url',
        'attachment_path',
        'is_free_preview',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_free_preview' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(LessonTranslation::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class);
    }

    public function getTitleAttribute(): string
    {
        return $this->translation()?->title ?? $this->slug;
    }

    public function getSummaryAttribute(): ?string
    {
        return $this->translation()?->summary;
    }

    public function getContentAttribute(): ?string
    {
        return $this->translation()?->content;
    }
}
