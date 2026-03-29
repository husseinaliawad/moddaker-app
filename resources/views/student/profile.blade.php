@extends('layouts.student')

@section('page-title', __('student.profile'))

@section('content')
    <form action="{{ route('student.profile.update') }}" method="post" enctype="multipart/form-data" class="card-surface max-w-3xl p-6">
        @csrf
        @method('patch')

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-semibold">{{ __('student.name') }}</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-border">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">{{ __('student.phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-xl border-border">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold">{{ __('student.language') }}</label>
                <select name="locale" class="w-full rounded-xl border-border">
                    @foreach ($supportedLocales as $localeCode)
                        <option value="{{ $localeCode }}" @selected(old('locale', $user->locale) === $localeCode)>
                            {{ strtoupper($localeCode) }} - {{ data_get($localeLabels ?? [], $localeCode, strtoupper($localeCode)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-semibold">{{ __('student.bio') }}</label>
                <textarea name="bio" rows="4" class="w-full rounded-xl border-border">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-semibold">{{ __('student.avatar') }}</label>
                <input type="file" name="avatar" class="w-full rounded-xl border-border">
            </div>
        </div>

        <button class="btn-primary mt-5">{{ __('student.save_profile') }}</button>
    </form>
@endsection
