<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\LessonTranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'locale',
        'title',
        'summary',
        'content',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
