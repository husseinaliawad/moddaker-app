@php($translationAr = isset($page) ? $page->translations->firstWhere('locale', 'ar') : null)
@php($translationEn = isset($page) ? $page->translations->firstWhere('locale', 'en') : null)

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.template') }}</label>
        <input type="text" name="template" value="{{ old('template', $page->template ?? 'default') }}" class="w-full rounded-xl border-border">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))>
        <label>{{ __('admin.published') }}</label>
    </div>
    <div></div>

    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.title_ar') }}</label>
        <input type="text" name="title_ar" value="{{ old('title_ar', $translationAr?->title) }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.title_en') }}</label>
        <input type="text" name="title_en" value="{{ old('title_en', $translationEn?->title) }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.excerpt_ar') }}</label>
        <textarea name="excerpt_ar" rows="3" class="w-full rounded-xl border-border">{{ old('excerpt_ar', $translationAr?->excerpt) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.excerpt_en') }}</label>
        <textarea name="excerpt_en" rows="3" class="w-full rounded-xl border-border">{{ old('excerpt_en', $translationEn?->excerpt) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.content_ar') }}</label>
        <textarea name="content_ar" rows="8" class="w-full rounded-xl border-border">{{ old('content_ar', $translationAr?->content) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.content_en') }}</label>
        <textarea name="content_en" rows="8" class="w-full rounded-xl border-border">{{ old('content_en', $translationEn?->content) }}</textarea>
    </div>
</div>

