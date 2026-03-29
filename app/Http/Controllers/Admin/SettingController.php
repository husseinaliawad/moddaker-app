<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function store(SettingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Setting::query()->updateOrCreate(
            ['key' => $validated['key']],
            [
                'group' => $validated['group'],
                'value' => $this->normalizeValue($validated['value'] ?? null),
            ]
        );

        return back()->with('success', __('messages.updated_successfully'));
    }

    public function update(SettingRequest $request, Setting $setting): RedirectResponse
    {
        $validated = $request->validated();

        $setting->update([
            'key' => $validated['key'],
            'group' => $validated['group'],
            'value' => $this->normalizeValue($validated['value'] ?? null),
        ]);

        return back()->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Setting $setting): RedirectResponse
    {
        $setting->delete();

        return back()->with('success', __('messages.deleted_successfully'));
    }

    private function normalizeValue(mixed $value): mixed
    {
        if (! is_string($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }
}
