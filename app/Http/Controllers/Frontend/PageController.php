<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Page;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = Page::query()
            ->with('translations')
            ->where('slug', 'about')
            ->where('is_published', true)
            ->first();

        $publishedCoursesCount = Course::query()->where('is_published', true)->count();
        $publishedLessonsCount = Course::query()->where('is_published', true)->sum('lessons_count');
        $activeLearnersCount = Enrollment::query()->distinct('user_id')->count('user_id');

        $stats = [
            [
                'value' => $activeLearnersCount.'+',
                'label' => __('about.stat_active_learners'),
            ],
            [
                'value' => $publishedCoursesCount.'+',
                'label' => __('about.stat_courses_live'),
            ],
            [
                'value' => $publishedLessonsCount.'+',
                'label' => __('about.stat_lessons_live'),
            ],
        ];

        $certificatesCount = max(Certificate::query()->count(), 1);

        return view('frontend.pages.about', compact('page', 'stats', 'certificatesCount'));
    }

    public function faq(): View
    {
        $page = Page::query()
            ->with('translations')
            ->where('slug', 'faq')
            ->where('is_published', true)
            ->first();

        $faqs = collect(range(1, 5))
            ->map(fn (int $index) => [
                'question' => __('faq.q'.$index),
                'answer' => __('faq.a'.$index),
            ])
            ->all();

        return view('frontend.pages.faq', compact('page', 'faqs'));
    }
}
