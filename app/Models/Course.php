<?php

namespace App\Models;

use App\Models\Concerns\InteractsWithTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory, InteractsWithTranslations;

    protected $fillable = [
        'category_id',
        'instructor_id',
        'slug',
        'level',
        'cover_image',
        'lessons_count',
        'duration_minutes',
        'price',
        'is_published',
        'is_featured',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CourseTranslation::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function getTitleAttribute(): string
    {
        return $this->translation()?->title ?? $this->slug;
    }

    public function getExcerptAttribute(): ?string
    {
        return $this->translation()?->excerpt;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->translation()?->description;
    }
}
