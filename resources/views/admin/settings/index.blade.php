@extends('layouts.admin')

@section('page-title', __('admin.settings'))

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <form action="{{ route('admin.settings.store') }}" method="post" class="card-surface p-5">
            @csrf
            <h2 class="text-lg font-bold">{{ __('admin.add_setting') }}</h2>
            <div class="mt-4 space-y-3">
                <input type="text" name="key" placeholder="{{ __('admin.setting_key') }}" class="w-full rounded-xl border-border" required>
                <input type="text" name="group" value="general" placeholder="{{ __('admin.group') }}" class="w-full rounded-xl border-border" required>
                <textarea name="value" rows="4" placeholder='{"ar":"...","en":"..."}' class="w-full rounded-xl border-border"></textarea>
                <button class="btn-primary text-sm">{{ __('admin.save') }}</button>
            </div>
        </form>

        <div class="card-surface p-5 lg:col-span-2">
            <h2 class="text-lg font-bold">{{ __('admin.settings_list') }}</h2>
            <div class="mt-4 space-y-5">
                @forelse ($settings as $group => $groupSettings)
                    <div>
                        <h3 class="mb-2 text-sm font-bold text-primary">{{ $group }}</h3>
                        <div class="space-y-3">
                            @foreach ($groupSettings as $setting)
                                <form action="{{ route('admin.settings.update', $setting) }}" method="post" class="rounded-xl bg-cream p-4">
                                    @csrf
                                    @method('put')
                                    <div class="grid gap-2 sm:grid-cols-[1fr_1fr_2fr_auto_auto] sm:items-start">
                                        <input type="text" name="key" value="{{ $setting->key }}" class="rounded-lg border-border text-sm">
                                        <input type="text" name="group" value="{{ $setting->group }}" class="rounded-lg border-border text-sm">
                                        <textarea name="value" rows="2" class="rounded-lg border-border text-sm">{{ is_array($setting->value) ? json_encode($setting->value, JSON_UNESCAPED_UNICODE) : $setting->value }}</textarea>
                                        <button class="rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-white">{{ __('admin.update') }}</button>
                                        <button form="delete-setting-{{ $setting->id }}" type="button" class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700" onclick="document.getElementById('delete-setting-{{ $setting->id }}').submit()">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </div>
                                </form>

                                <form id="delete-setting-{{ $setting->id }}" action="{{ route('admin.settings.destroy', $setting) }}" method="post" class="hidden">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-charcoal/60">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

