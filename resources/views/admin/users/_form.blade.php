@php($isEdit = isset($user))

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('student.name') }}</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('contact.email') }}</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded-xl border-border" required>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('student.phone') }}</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('student.language') }}</label>
        <select name="locale" class="w-full rounded-xl border-border">
            @foreach ($supportedLocales as $localeCode)
                <option value="{{ $localeCode }}" @selected(old('locale', $user->locale ?? config('app.locale', 'ar')) === $localeCode)>
                    {{ strtoupper($localeCode) }} - {{ data_get($localeLabels ?? [], $localeCode, strtoupper($localeCode)) }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('auth.password') }}</label>
        <input type="password" name="password" class="w-full rounded-xl border-border" {{ $isEdit ? '' : 'required' }}>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('auth.confirm_password') }}</label>
        <input type="password" name="password_confirmation" class="w-full rounded-xl border-border" {{ $isEdit ? '' : 'required' }}>
    </div>
    <div class="sm:col-span-2">
        <label class="mb-1 block text-sm font-semibold">{{ __('student.bio') }}</label>
        <textarea name="bio" rows="4" class="w-full rounded-xl border-border">{{ old('bio', $user->bio ?? '') }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('student.avatar') }}</label>
        <input type="file" name="avatar" class="w-full rounded-xl border-border">
    </div>
    <div>
        <label class="mb-1 block text-sm font-semibold">{{ __('admin.roles_permissions') }}</label>
        <select name="roles[]" multiple class="w-full rounded-xl border-border">
            @foreach ($roles as $role)
                <option
                    value="{{ $role->name }}"
                    @selected(collect(old('roles', isset($user) ? $user->roles->pluck('name')->all() : []))->contains($role->name))
                >
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
