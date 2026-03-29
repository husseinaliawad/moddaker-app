<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index(): View
    {
        $certificates = Certificate::query()
            ->with(['user', 'course.translations'])
            ->latest('issued_at')
            ->paginate(15);

        $users = User::query()->orderBy('name')->get();
        $courses = Course::query()->with('translations')->orderBy('id', 'desc')->get();

        return view('admin.certificates.index', compact('certificates', 'users', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        Certificate::query()->updateOrCreate(
            ['user_id' => $validated['user_id'], 'course_id' => $validated['course_id']],
            [
                'serial_number' => 'MDK-'.Str::upper(Str::random(10)),
                'issued_at' => now(),
            ]
        );

        return back()->with('success', __('messages.created_successfully'));
    }
}
