<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        $lessonId = $this->route('lesson')?->id ?? $this->route('lesson');
        $courseId = (int) $this->input('course_id');

        return [
            'course_id' => ['required', 'exists:courses,id'],
            'slug' => [
                'required',
                'string',
                'max:180',
                Rule::unique('lessons', 'slug')
                    ->where(fn ($query) => $query->where('course_id', $courseId))
                    ->ignore($lessonId),
            ],
            'order_column' => ['required', 'integer', 'min:1'],
            'duration_minutes' => ['nullable', 'integer', 'min:0'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'attachment' => ['nullable', 'file', 'max:8192'],
            'is_free_preview' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'summary_ar' => ['nullable', 'string', 'max:1000'],
            'summary_en' => ['nullable', 'string', 'max:1000'],
            'content_ar' => ['nullable', 'string'],
            'content_en' => ['nullable', 'string'],
        ];
    }
}
