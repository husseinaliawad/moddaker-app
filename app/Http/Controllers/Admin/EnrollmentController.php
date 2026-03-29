<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Enrollment::query()->with(['user', 'course.translations'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $enrollments = $query->paginate(15)->withQueryString();

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function update(Request $request, Enrollment $enrollment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:active,completed,cancelled'],
            'progress_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $enrollment->update([
            'status' => $validated['status'],
            'progress_percent' => $validated['progress_percent'] ?? $enrollment->progress_percent,
            'completed_at' => $validated['status'] === 'completed' ? now() : null,
        ]);

        return back()->with('success', __('messages.updated_successfully'));
    }
}
