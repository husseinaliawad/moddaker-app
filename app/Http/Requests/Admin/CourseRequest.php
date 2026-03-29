<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
        $courseId = $this->route('course')?->id ?? $this->route('course');

        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'instructor_id' => ['nullable', 'exists:instructors,id'],
            'slug' => ['required', 'string', 'max:180', Rule::unique('courses', 'slug')->ignore($courseId)],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'duration_minutes' => ['nullable', 'integer', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'excerpt_ar' => ['nullable', 'string', 'max:800'],
            'excerpt_en' => ['nullable', 'string', 'max:800'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'objectives_ar' => ['nullable', 'string'],
            'objectives_en' => ['nullable', 'string'],
        ];
    }
}
