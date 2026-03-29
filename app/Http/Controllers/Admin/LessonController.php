<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lesson::query()
            ->with(['translations', 'course.translations'])
            ->latest();

        if ($request->filled('course_id')) {
            $query->where('course_id', (int) $request->input('course_id'));
        }

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('slug', 'like', "%{$search}%")
                    ->orWhereHas('translations', fn ($translationQuery) => $translationQuery->where('title', 'like', "%{$search}%"));
            });
        }

        $lessons = $query->paginate(15)->withQueryString();
        $courses = Course::query()->with('translations')->orderBy('id', 'desc')->get();

        return view('admin.lessons.index', compact('lessons', 'courses'));
    }

    public function create(): View
    {
        $courses = Course::query()->with('translations')->orderBy('id', 'desc')->get();

        return view('admin.lessons.create', compact('courses'));
    }

    public function store(LessonRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('lessons/attachments', 'public');
        }

        $lesson = Lesson::query()->create([
            'course_id' => $validated['course_id'],
            'slug' => $validated['slug'],
            'order_column' => $validated['order_column'],
            'duration_minutes' => $validated['duration_minutes'] ?? 0,
            'video_url' => $validated['video_url'] ?? null,
            'attachment_path' => $validated['attachment_path'] ?? null,
            'is_free_preview' => (bool) ($validated['is_free_preview'] ?? false),
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ]);

        $this->syncTranslations($lesson, $validated);
        $this->refreshLessonCount($lesson->course);

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Lesson $lesson): View
    {
        $lesson->load('translations');
        $courses = Course::query()->with('translations')->orderBy('id', 'desc')->get();

        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    public function update(LessonRequest $request, Lesson $lesson): RedirectResponse
    {
        $validated = $request->validated();
        $previousCourse = $lesson->course;

        if ($request->hasFile('attachment')) {
            $validated['attachment_path'] = $request->file('attachment')->store('lessons/attachments', 'public');
        }

        $lesson->update([
            'course_id' => $validated['course_id'],
            'slug' => $validated['slug'],
            'order_column' => $validated['order_column'],
            'duration_minutes' => $validated['duration_minutes'] ?? 0,
            'video_url' => $validated['video_url'] ?? null,
            'attachment_path' => $validated['attachment_path'] ?? $lesson->attachment_path,
            'is_free_preview' => (bool) ($validated['is_free_preview'] ?? false),
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ]);

        $this->syncTranslations($lesson, $validated);
        $this->refreshLessonCount($lesson->course);

        if ($previousCourse && $previousCourse->id !== $lesson->course_id) {
            $this->refreshLessonCount($previousCourse);
        }

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Lesson $lesson): RedirectResponse
    {
        $course = $lesson->course;
        $lesson->delete();

        if ($course) {
            $this->refreshLessonCount($course);
        }

        return redirect()
            ->route('admin.lessons.index')
            ->with('success', __('messages.deleted_successfully'));
    }

    private function syncTranslations(Lesson $lesson, array $validated): void
    {
        foreach (['ar', 'en'] as $locale) {
            $lesson->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $validated['title_'.$locale],
                    'summary' => $validated['summary_'.$locale] ?? null,
                    'content' => $validated['content_'.$locale] ?? null,
                ]
            );
        }
    }

    private function refreshLessonCount(Course $course): void
    {
        $course->update([
            'lessons_count' => $course->lessons()->count(),
        ]);
    }
}
