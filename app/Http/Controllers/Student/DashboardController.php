<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Progress;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $enrollments = Enrollment::query()
            ->with(['course.translations'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $recentLessons = Progress::query()
            ->with(['lesson.translations', 'lesson.course.translations'])
            ->whereHas('enrollment', fn ($query) => $query->where('user_id', $user->id))
            ->where('is_completed', true)
            ->latest('completed_at')
            ->take(5)
            ->get();

        $stats = [
            'enrolled_courses' => $enrollments->count(),
            'completed_courses' => $enrollments->where('status', 'completed')->count(),
            'average_progress' => round($enrollments->avg('progress_percent') ?? 0, 1),
            'certificates' => Certificate::query()->where('user_id', $user->id)->count(),
        ];

        return view('student.dashboard', compact('enrollments', 'recentLessons', 'stats'));
    }

    public function courses(): View
    {
        $enrollments = Enrollment::query()
            ->with(['course.translations', 'course.instructor'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('student.courses', compact('enrollments'));
    }

    public function progress(): View
    {
        $enrollments = Enrollment::query()
            ->with(['course.translations', 'progresses.lesson.translations'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('student.progress', compact('enrollments'));
    }

    public function certificates(): View
    {
        $certificates = Certificate::query()
            ->with('course.translations')
            ->where('user_id', auth()->id())
            ->latest('issued_at')
            ->paginate(10);

        return view('student.certificates', compact('certificates'));
    }
}
