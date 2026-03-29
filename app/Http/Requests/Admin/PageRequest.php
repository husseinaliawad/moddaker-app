<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
        $pageId = $this->route('page')?->id ?? $this->route('page');

        return [
            'slug' => ['required', 'string', 'max:150', Rule::unique('pages', 'slug')->ignore($pageId)],
            'template' => ['nullable', 'string', 'max:80'],
            'is_published' => ['nullable', 'boolean'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'excerpt_ar' => ['nullable', 'string', 'max:1000'],
            'excerpt_en' => ['nullable', 'string', 'max:1000'],
            'content_ar' => ['nullable', 'string'],
            'content_en' => ['nullable', 'string'],
        ];
    }
}
