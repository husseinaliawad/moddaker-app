<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuizRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(): View
    {
        $quizzes = Quiz::query()
            ->with(['course.translations', 'lesson.translations'])
            ->latest()
            ->paginate(12);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create(): View
    {
        $courses = Course::query()->with('translations')->get();
        $lessons = Lesson::query()->with('translations')->get();

        return view('admin.quizzes.create', compact('courses', 'lessons'));
    }

    public function store(QuizRequest $request): RedirectResponse
    {
        Quiz::query()->create([
            ...$request->validated(),
            'is_published' => (bool) $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.quizzes.index')->with('success', __('messages.created_successfully'));
    }

    public function edit(Quiz $quiz): View
    {
        $courses = Course::query()->with('translations')->get();
        $lessons = Lesson::query()->with('translations')->get();

        return view('admin.quizzes.edit', compact('quiz', 'courses', 'lessons'));
    }

    public function update(QuizRequest $request, Quiz $quiz): RedirectResponse
    {
        $quiz->update([
            ...$request->validated(),
            'is_published' => (bool) $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.quizzes.index')->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')->with('success', __('messages.deleted_successfully'));
    }
}
