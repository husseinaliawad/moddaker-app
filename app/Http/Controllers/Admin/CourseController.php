<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::query()
            ->with(['translations', 'category.translations', 'instructor'])
            ->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('slug', 'like', "%{$search}%")
                    ->orWhereHas('translations', fn ($translationQuery) => $translationQuery->where('title', 'like', "%{$search}%"));
            });
        }

        $courses = $query->paginate(12)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    public function create(): View
    {
        $categories = Category::query()->with('translations')->orderBy('sort_order')->get();
        $instructors = Instructor::query()->orderBy('name')->get();

        return view('admin.courses.create', compact('categories', 'instructors'));
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $course = Course::query()->create([
            'category_id' => $validated['category_id'] ?? null,
            'instructor_id' => $validated['instructor_id'] ?? null,
            'slug' => $validated['slug'],
            'level' => $validated['level'],
            'cover_image' => $validated['cover_image'] ?? null,
            'duration_minutes' => $validated['duration_minutes'] ?? 0,
            'price' => $validated['price'] ?? 0,
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
        ]);

        $this->syncTranslations($course, $validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Course $course): View
    {
        $course->load('translations');
        $categories = Category::query()->with('translations')->orderBy('sort_order')->get();
        $instructors = Instructor::query()->orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'categories', 'instructors'));
    }

    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $course->update([
            'category_id' => $validated['category_id'] ?? null,
            'instructor_id' => $validated['instructor_id'] ?? null,
            'slug' => $validated['slug'],
            'level' => $validated['level'],
            'cover_image' => $validated['cover_image'] ?? $course->cover_image,
            'duration_minutes' => $validated['duration_minutes'] ?? 0,
            'price' => $validated['price'] ?? 0,
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
            'published_at' => ($validated['is_published'] ?? false) ? ($course->published_at ?? now()) : null,
        ]);

        $this->syncTranslations($course, $validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', __('messages.deleted_successfully'));
    }

    private function syncTranslations(Course $course, array $validated): void
    {
        foreach (['ar', 'en'] as $locale) {
            $course->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $validated['title_'.$locale],
                    'excerpt' => $validated['excerpt_'.$locale] ?? null,
                    'description' => $validated['description_'.$locale] ?? null,
                    'objectives' => $validated['objectives_'.$locale] ?? null,
                ]
            );
        }
    }
}
