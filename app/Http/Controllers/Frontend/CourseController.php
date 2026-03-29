<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::query()
            ->with(['translations', 'category.translations', 'instructor'])
            ->where('is_published', true);

        if ($request->filled('level')) {
            $query->where('level', $request->string('level')->toString());
        }

        if ($request->filled('category')) {
            $categorySlug = $request->string('category')->toString();
            $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $categorySlug));
        }

        $sort = $request->string('sort')->toString();

        switch ($sort) {
            case 'newest':
                $query->orderByDesc('published_at')->orderByDesc('id');
                break;
            case 'popular':
                $query->withCount('enrollments')
                    ->orderByDesc('enrollments_count')
                    ->orderByDesc('is_featured')
                    ->orderBy('sort_order');
                break;
            case 'duration_asc':
                $query->orderBy('duration_minutes')->orderByDesc('is_featured');
                break;
            case 'duration_desc':
                $query->orderByDesc('duration_minutes')->orderByDesc('is_featured');
                break;
            default:
                $query->orderByDesc('is_featured')->orderBy('sort_order');
                break;
        }

        $courses = $query->paginate(9)->withQueryString();

        $categories = Category::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.courses.index', compact('courses', 'categories'));
    }

    public function show(Course $course): View
    {
        $course->load([
            'translations',
            'category.translations',
            'instructor',
            'lessons' => fn ($query) => $query
                ->where('is_published', true)
                ->orderBy('order_column')
                ->with('translations'),
        ]);

        $enrollment = auth()->check()
            ? Enrollment::query()
                ->where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->first()
            : null;

        $completedLessonIds = $enrollment
            ? Progress::query()
                ->where('enrollment_id', $enrollment->id)
                ->where('is_completed', true)
                ->pluck('lesson_id')
            : collect();

        return view('frontend.courses.show', compact('course', 'enrollment', 'completedLessonIds'));
    }

    public function lesson(Course $course, Lesson $lesson): View|RedirectResponse
    {
        abort_if($lesson->course_id !== $course->id, 404);

        $lesson->load('translations');
        $course->load('translations', 'lessons.translations');

        $enrollment = auth()->check()
            ? Enrollment::query()
                ->where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->first()
            : null;

        if (! $lesson->is_free_preview && ! $enrollment && ! auth()->user()?->hasRole('admin')) {
            return redirect()
                ->route('courses.show', $course)
                ->with('error', __('messages.enroll_to_access'));
        }

        return view('frontend.lessons.show', compact('course', 'lesson', 'enrollment'));
    }

    public function completeLesson(Course $course, Lesson $lesson): RedirectResponse
    {
        abort_if($lesson->course_id !== $course->id, 404);

        $enrollment = Enrollment::query()->firstOrCreate(
            ['user_id' => auth()->id(), 'course_id' => $course->id],
            ['status' => 'active', 'enrolled_at' => now()]
        );

        Progress::query()->updateOrCreate(
            ['enrollment_id' => $enrollment->id, 'lesson_id' => $lesson->id],
            ['is_completed' => true, 'completed_at' => now()]
        );

        $totalLessons = $course->lessons()->where('is_published', true)->count();
        $completedLessons = Progress::query()
            ->where('enrollment_id', $enrollment->id)
            ->where('is_completed', true)
            ->whereHas('lesson', fn ($query) => $query->where('course_id', $course->id))
            ->count();

        $progressPercent = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 2) : 0;

        $enrollment->update([
            'progress_percent' => $progressPercent,
            'status' => $progressPercent >= 100 ? 'completed' : 'active',
            'completed_at' => $progressPercent >= 100 ? now() : null,
        ]);

        return back()->with('success', __('messages.lesson_completed'));
    }
}
