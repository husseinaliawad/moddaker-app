<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.course') }}</label>
        <select name="course_id" class="w-full rounded-xl border-border">
            <option value="">{{ __('admin.none') }}</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @selected(old('course_id', $quiz->course_id ?? null) == $course->id)>{{ $course->title }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.lesson') }}</label>
        <select name="lesson_id" class="w-full rounded-xl border-border">
            <option value="">{{ __('admin.none') }}</option>
            @foreach ($lessons as $lesson)
                <option value="{{ $lesson->id }}" @selected(old('lesson_id', $quiz->lesson_id ?? null) == $lesson->id)>{{ $lesson->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="sm:col-span-2">
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.title') }}</label>
        <input type="text" name="title" value="{{ old('title', $quiz->title ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.passing_score') }}</label>
        <input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score ?? 70) }}" class="w-full rounded-xl border-border">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $quiz->is_published ?? true))>
        <label>{{ __('admin.published') }}</label>
    </div>
    <div class="sm:col-span-2">
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.instructions') }}</label>
        <textarea name="instructions" rows="5" class="w-full rounded-xl border-border">{{ old('instructions', $quiz->instructions ?? '') }}</textarea>
    </div>
</div>

