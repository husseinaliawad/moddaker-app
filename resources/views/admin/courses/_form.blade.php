@php($translationAr = isset($course) ? $course->translations->firstWhere('locale', 'ar') : null)
@php($translationEn = isset($course) ? $course->translations->firstWhere('locale', 'en') : null)

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $course->slug ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.level') }}</label>
        <select name="level" class="w-full rounded-xl border-border">
            @foreach (['beginner', 'intermediate', 'advanced'] as $level)
                <option value="{{ $level }}" @selected(old('level', $course->level ?? 'beginner') === $level)>{{ __('levels.'.$level) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.category') }}</label>
        <select name="category_id" class="w-full rounded-xl border-border">
            <option value="">{{ __('admin.none') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id ?? null) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.instructor') }}</label>
        <select name="instructor_id" class="w-full rounded-xl border-border">
            <option value="">{{ __('admin.none') }}</option>
            @foreach ($instructors as $instructor)
                <option value="{{ $instructor->id }}" @selected(old('instructor_id', $course->instructor_id ?? null) == $instructor->id)>
                    {{ $instructor->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.duration_minutes') }}</label>
        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $course->duration_minutes ?? 0) }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.price') }}</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $course->price ?? 0) }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.sort_order') }}</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $course->sort_order ?? 0) }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.cover_image') }}</label>
        <input type="file" name="cover_image" class="w-full rounded-xl border-border">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $course->is_published ?? true))>
        <label>{{ __('admin.published') }}</label>
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $course->is_featured ?? false))>
        <label>{{ __('admin.featured') }}</label>
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
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.excerpt_ar') }}</label>
        <textarea name="excerpt_ar" rows="3" class="w-full rounded-xl border-border">{{ old('excerpt_ar', $translationAr?->excerpt) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.excerpt_en') }}</label>
        <textarea name="excerpt_en" rows="3" class="w-full rounded-xl border-border">{{ old('excerpt_en', $translationEn?->excerpt) }}</textarea>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.description_ar') }}</label>
        <textarea name="description_ar" rows="5" class="w-full rounded-xl border-border">{{ old('description_ar', $translationAr?->description) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.description_en') }}</label>
        <textarea name="description_en" rows="5" class="w-full rounded-xl border-border">{{ old('description_en', $translationEn?->description) }}</textarea>
    </div>

    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.objectives_ar') }}</label>
        <textarea name="objectives_ar" rows="4" class="w-full rounded-xl border-border">{{ old('objectives_ar', $translationAr?->objectives) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.objectives_en') }}</label>
        <textarea name="objectives_en" rows="4" class="w-full rounded-xl border-border">{{ old('objectives_en', $translationEn?->objectives) }}</textarea>
    </div>
</div>

