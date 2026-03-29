@extends('layouts.frontend')

@php
    $coverImage = $course->cover_image
        ? asset('storage/'.$course->cover_image)
        : asset('images/about-hero-visual.svg');

    $lessonSummary = \Illuminate\Support\Str::limit(trim(strip_tags((string) $lesson->summary)), 155, '');
    $metaTitle = \Illuminate\Support\Str::limit($lesson->title.' | '.__('app.site_name'), 60, '');
    $metaKeywords = app()->getLocale() === 'ar'
        ? 'درس تفسير, مقالة تعليمية قرآنية, منصة مدكر, تعلم القرآن'
        : 'Quran lesson article, tafsir lesson, Islamic article, Moddaker';

    $articleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $lesson->title,
        'description' => \Illuminate\Support\Str::limit(trim(strip_tags((string) ($lesson->summary ?: $lesson->content))), 220, ''),
        'image' => $coverImage,
        'mainEntityOfPage' => route('lessons.show', [$course, $lesson]),
        'articleSection' => $course->title,
        'inLanguage' => str_replace('_', '-', app()->getLocale()),
        'datePublished' => $lesson->created_at?->toAtomString(),
        'dateModified' => $lesson->updated_at?->toAtomString(),
        'author' => [
            '@type' => 'Person',
            'name' => $course->instructor?->name ?: __('app.site_name'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => __('app.site_name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/moddaker-logo.svg'),
            ],
        ],
    ];
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $lessonSummary)
@section('meta_keywords', $metaKeywords)
@section('canonical_url', route('lessons.show', [$course, $lesson]))
@section('og_type', 'article')
@section('og_image', $coverImage)
@section('og_image_alt', $lesson->title)
@section('twitter_image', $coverImage)

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($articleSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    @php
        $orderedLessons = $course->lessons->sortBy('order_column')->values();
        $currentIndex = $orderedLessons->search(fn ($item) => $item->id === $lesson->id);
        $previousLesson = $currentIndex > 0 ? $orderedLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex !== false && $currentIndex < $orderedLessons->count() - 1 ? $orderedLessons[$currentIndex + 1] : null;
    @endphp

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('courses.show', $course) }}" class="text-sm font-semibold text-primary hover:underline">
                {{ __('lessons.back_to_course') }}
            </a>

            <h1 class="font-display mt-4 text-4xl text-charcoal">{{ $lesson->title }}</h1>
            <p class="mt-3 text-charcoal/70">{{ $lesson->summary }}</p>

            <div class="mt-7 overflow-hidden rounded-3xl border border-border bg-charcoal/5">
                @if ($lesson->video_url)
                    <iframe
                        src="{{ $lesson->video_url }}"
                        class="h-[260px] w-full sm:h-[420px]"
                        title="{{ $lesson->title }}"
                        loading="lazy"
                        allowfullscreen
                    ></iframe>
                @else
                    <div class="flex h-[260px] items-center justify-center sm:h-[420px]">
                        <p class="text-charcoal/60">{{ __('lessons.no_video') }}</p>
                    </div>
                @endif
            </div>

            <article class="prose prose-slate mt-8 max-w-none rounded-2xl border border-border bg-cream p-6">
                {!! nl2br(e($lesson->content)) !!}
            </article>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <form method="post" action="{{ route('lessons.complete', [$course, $lesson]) }}">
                    @csrf
                    <button class="btn-primary" aria-label="{{ __('lessons.mark_complete') }}">{{ __('lessons.mark_complete') }}</button>
                </form>

                @if ($previousLesson)
                    <a href="{{ route('lessons.show', [$course, $previousLesson]) }}" class="btn-secondary" aria-label="{{ __('lessons.previous') }}: {{ $previousLesson->title }}">
                        {{ __('lessons.previous') }}
                    </a>
                @endif

                @if ($nextLesson)
                    <a href="{{ route('lessons.show', [$course, $nextLesson]) }}" class="btn-secondary" aria-label="{{ __('lessons.next') }}: {{ $nextLesson->title }}">
                        {{ __('lessons.next') }}
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection
