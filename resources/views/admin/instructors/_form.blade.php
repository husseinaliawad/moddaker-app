<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('student.name') }}</label>
        <input type="text" name="name" value="{{ old('name', $instructor->name ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.title') }}</label>
        <input type="text" name="title" value="{{ old('title', $instructor->title ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.linked_user') }}</label>
        <select name="user_id" class="w-full rounded-xl border-border">
            <option value="">{{ __('admin.none') }}</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $instructor->user_id ?? null) == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('student.avatar') }}</label>
        <input type="file" name="avatar" class="w-full rounded-xl border-border">
    </div>
    <div class="sm:col-span-2">
        <label class="mb-1 block text-sm font-semibold">{{ __('student.bio') }}</label>
        <textarea name="bio" rows="4" class="w-full rounded-xl border-border">{{ old('bio', $instructor->bio ?? '') }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">X</label>
        <input type="url" name="social_links[x]" value="{{ old('social_links.x', $instructor->social_links['x'] ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">YouTube</label>
        <input type="url" name="social_links[youtube]" value="{{ old('social_links.youtube', $instructor->social_links['youtube'] ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div class="sm:col-span-2">
        <label class="mb-1 block text-sm font-semibold">Telegram</label>
        <input type="url" name="social_links[telegram]" value="{{ old('social_links.telegram', $instructor->social_links['telegram'] ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $instructor->is_active ?? true))>
        <label>{{ __('admin.active') }}</label>
    </div>
</div>
