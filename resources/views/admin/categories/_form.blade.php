@php($translationAr = isset($category) ? $category->translations->firstWhere('locale', 'ar') : null)
@php($translationEn = isset($category) ? $category->translations->firstWhere('locale', 'en') : null)

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.icon') }}</label>
        <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.sort_order') }}</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="w-full rounded-xl border-border">
    </div>
    <div class="flex items-center gap-2 pt-6">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
        <label class="text-sm font-semibold">{{ __('admin.active') }}</label>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.name_ar') }}</label>
        <input type="text" name="name_ar" value="{{ old('name_ar', $translationAr?->name) }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.name_en') }}</label>
        <input type="text" name="name_en" value="{{ old('name_en', $translationEn?->name) }}" class="w-full rounded-xl border-border" required>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.description_ar') }}</label>
        <textarea name="description_ar" rows="3" class="w-full rounded-xl border-border">{{ old('description_ar', $translationAr?->description) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.description_en') }}</label>
        <textarea name="description_en" rows="3" class="w-full rounded-xl border-border">{{ old('description_en', $translationEn?->description) }}</textarea>
    </div>
</div>

