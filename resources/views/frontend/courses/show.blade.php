@extends('layouts.frontend')

@php
    $coverImage = $course->cover_image
        ? asset('storage/'.$course->cover_image)
        : asset('images/about-hero-visual.svg');

    $courseDescription = \Illuminate\Support\Str::limit(
        trim(strip_tags((string) ($course->description ?: $course->excerpt))),
        155,
        ''
    );

    $metaTitle = \Illuminate\Support\Str::limit($course->title.' | '.__('app.site_name'), 60, '');
    $metaKeywords = app()->getLocale() === 'ar'
        ? 'دورة تفسير القرآن, تعلم القرآن, منصة مدكر, دروس إسلامية'
        : 'Quran tafsir course, online Quran lessons, Islamic learning, Moddaker';

    $courseSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        'name' => $course->title,
        'description' => \Illuminate\Support\Str::limit(trim(strip_tags((string) ($course->description ?: $course->excerpt))), 220, ''),
        'url' => route('courses.show', $course),
        'image' => $coverImage,
        'inLanguage' => str_replace('_', '-', app()->getLocale()),
        'educationalLevel' => __('levels.'.$course->level),
        'timeRequired' => 'PT'.max((int) $course->duration_minutes, 1).'M',
        'provider' => [
            '@type' => 'Organization',
            'name' => __('app.site_name'),
            'url' => route('home'),
        ],
        'hasPart' => $course->lessons->map(fn ($lesson) => [
            '@type' => 'CreativeWork',
            'name' => $lesson->title,
            'url' => route('lessons.show', [$course, $lesson]),
        ])->values()->all(),
    ];

    if (filled($course->instructor?->name)) {
        $courseSchema['instructor'] = [
            '@type' => 'Person',
            'name' => $course->instructor->name,
        ];
    }
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $courseDescription)
@section('meta_keywords', $metaKeywords)
@section('canonical_url', route('courses.show', $course))
@section('og_type', 'website')
@section('og_image', $coverImage)
@section('og_image_alt', $course->title)
@section('twitter_image', $coverImage)

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($courseSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-3">
                <article class="lg:col-span-2">
                    <img
                        src="{{ $coverImage }}"
                        alt="{{ $course->title }}"
                        class="h-64 w-full rounded-3xl object-cover shadow-xl sm:h-80"
                        loading="eager"
                        fetchpriority="high"
                        decoding="async"
                    >

                    <h1 class="font-display mt-7 text-4xl text-charcoal">{{ $course->title }}</h1>
                    <p class="mt-4 leading-relaxed text-charcoal/70">{{ $course->description }}</p>

                    <section class="mt-8" aria-labelledby="course-lessons-title">
                        <h2 id="course-lessons-title" class="mb-4 text-2xl font-bold text-charcoal">{{ __('courses.lessons_list') }}</h2>
                        <div class="space-y-3">
                            @foreach ($course->lessons as $lesson)
                                @php($completed = $completedLessonIds->contains($lesson->id))
                                <article class="card-surface p-4">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <h3 class="font-bold text-charcoal">{{ $lesson->title }}</h3>
                                            <p class="text-sm text-charcoal/60">{{ $lesson->summary }}</p>
                                            <p class="mt-2 text-xs text-charcoal/50">
                                                {{ __('courses.lesson_duration', ['minutes' => $lesson->duration_minutes]) }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if ($completed)
                                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                                    {{ __('courses.completed') }}
                                                </span>
                                            @endif

                                            @if ($lesson->is_free_preview || $enrollment || auth()->user()?->hasRole('admin'))
                                                <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="btn-primary text-sm" aria-label="{{ __('courses.open_lesson') }}: {{ $lesson->title }}">
                                                    {{ __('courses.open_lesson') }}
                                                </a>
                                            @else
                                                <span class="rounded-xl border border-border px-3 py-2 text-xs text-charcoal/60">
                                                    {{ __('courses.locked') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </article>

                <aside class="card-surface h-fit p-6">
                    <h2 class="text-xl font-bold text-charcoal">{{ __('courses.course_info') }}</h2>
                    <div class="mt-4 space-y-3 text-sm text-charcoal/70">
                        <div class="flex justify-between">
                            <span>{{ __('courses.level') }}</span>
                            <span class="font-semibold text-primary">{{ __('levels.'.$course->level) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>{{ __('courses.lessons') }}</span>
                            <span class="font-semibold">{{ $course->lessons_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>{{ __('courses.duration') }}</span>
                            <span class="font-semibold">{{ $course->duration_minutes }} {{ __('courses.minutes') }}</span>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('student.courses') }}" class="btn-secondary mt-6 inline-flex w-full justify-center" aria-label="{{ __('courses.my_courses') }}">
                            {{ __('courses.my_courses') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary mt-6 inline-flex w-full justify-center" aria-label="{{ __('courses.enroll_now') }}">
                            {{ __('courses.enroll_now') }}
                        </a>
                    @endauth

                    <nav class="mt-4 space-y-2 text-sm" aria-label="Course related links">
                        <a href="{{ route('courses.index') }}" class="inline-flex font-semibold text-primary hover:underline">
                            {{ app()->getLocale() === 'ar' ? 'استعرض جميع الدورات التعليمية' : 'Browse all learning courses' }}
                        </a>
                        <a href="{{ route('faq') }}" class="inline-flex font-semibold text-primary hover:underline">
                            {{ app()->getLocale() === 'ar' ? 'الأسئلة الشائعة حول التسجيل والدورات' : 'FAQ about enrollment and courses' }}
                        </a>
                    </nav>
                </aside>
            </div>
        </div>
    </section>
@endsection
