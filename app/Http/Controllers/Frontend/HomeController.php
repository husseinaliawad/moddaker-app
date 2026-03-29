<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(): View
    {
        $courses = Schema::hasTable('courses')
            ? Course::query()
                ->with(['translations', 'instructor', 'category.translations'])
                ->where('is_published', true)
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->take(6)
                ->get()
            : new Collection();

        $hero = Setting::getValue('home.hero', [
            'badge' => [
                'ar' => 'منصة تعليمية متخصصة',
                'en' => 'Specialized Learning Platform',
            ],
            'title' => [
                'ar' => 'ابدأ رحلتك في فهم القرآن الكريم',
                'en' => 'Start Your Journey in Understanding the Quran',
            ],
            'description' => [
                'ar' => 'تعلّم التفسير بأسلوب مبسط ومنهجي مع نخبة من العلماء والمدرسين المؤهلين.',
                'en' => 'Learn Quran interpretation with a clear and structured method from expert scholars.',
            ],
        ]);

        $cta = Setting::getValue('home.cta', [
            'title' => ['ar' => 'ابدأ رحلتك اليوم', 'en' => 'Begin Your Journey Today'],
            'description' => [
                'ar' => 'انضم إلى آلاف الطلاب الذين بدأوا رحلتهم في فهم كتاب الله.',
                'en' => 'Join thousands of learners studying the Book of Allah.',
            ],
        ]);

        return view('frontend.home', compact('courses', 'hero', 'cta'));
    }
}
