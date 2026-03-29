@php($translationAr = isset($lesson) ? $lesson->translations->firstWhere('locale', 'ar') : null)
@php($translationEn = isset($lesson) ? $lesson->translations->firstWhere('locale', 'en') : null)

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.course') }}</label>
        <select name="course_id" class="w-full rounded-xl border-border" required>
            @foreach ($courses as $courseOption)
                <option value="{{ $courseOption->id }}" @selected(old('course_id', $lesson->course_id ?? null) == $courseOption->id)>
                    {{ $courseOption->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $lesson->slug ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.order') }}</label>
        <input type="number" name="order_column" value="{{ old('order_column', $lesson->order_column ?? 1) }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.duration_minutes') }}</label>
        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $lesson->duration_minutes ?? 0) }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.video_url') }}</label>
        <input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.attachment') }}</label>
        <input type="file" name="attachment" class="w-full rounded-xl border-border">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_free_preview" value="1" @checked(old('is_free_preview', $lesson->is_free_preview ?? false))>
        <label>{{ __('admin.free_preview') }}</label>
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $lesson->is_published ?? true))>
        <label>{{ __('admin.published') }}</label>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.title_ar') }}</label>
        <input type="text" name="title_ar" value="{{ old('title_ar', $translationAr?->title) }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.title_en') }}</label>
        <input type="text" name="title_en" value="{{ old('title_en', $translationEn?->title) }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.summary_ar') }}</label>
        <textarea name="summary_ar" rows="3" class="w-full rounded-xl border-border">{{ old('summary_ar', $translationAr?->summary) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.summary_en') }}</label>
        <textarea name="summary_en" rows="3" class="w-full rounded-xl border-border">{{ old('summary_en', $translationEn?->summary) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.content_ar') }}</label>
        <textarea name="content_ar" rows="6" class="w-full rounded-xl border-border">{{ old('content_ar', $translationAr?->content) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.content_en') }}</label>
        <textarea name="content_en" rows="6" class="w-full rounded-xl border-border">{{ old('content_en', $translationEn?->content) }}</textarea>
    </div>
</div>

