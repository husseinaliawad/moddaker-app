<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\CourseTranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'locale',
        'title',
        'excerpt',
        'description',
        'objectives',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
