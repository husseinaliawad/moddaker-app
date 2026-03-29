@extends('layouts.frontend')

@php
    $locale = app()->getLocale();
    $metaTitle = \Illuminate\Support\Str::limit(__('courses.title').' | '.__('app.site_name'), 60, '');
    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags(__('courses.subtitle'))), 155, '');
    $metaKeywords = $locale === 'ar'
        ? 'دورات تفسير القرآن, دورات إسلامية, تعلم القرآن أونلاين, منصة مدكر'
        : 'Quran courses, tafsir lessons, online Islamic learning, Moddaker courses';

    $canonicalQuery = request()->except('page');
    $canonicalUrl = route('courses.index').(count($canonicalQuery) ? '?'.http_build_query($canonicalQuery) : '');

    $startPosition = $courses->firstItem() ?? 1;
    $coursesListSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'name' => __('courses.title'),
        'itemListElement' => $courses->getCollection()->values()->map(fn ($course, $index) => [
            '@type' => 'ListItem',
            'position' => $startPosition + $index,
            'url' => route('courses.show', $course),
            'item' => [
                '@type' => 'Course',
                'name' => $course->title,
                'description' => \Illuminate\Support\Str::limit((string) $course->excerpt, 200, ''),
                'provider' => [
                    '@type' => 'Organization',
                    'name' => __('app.site_name'),
                    'url' => route('home'),
                ],
                'image' => $course->cover_image
                    ? asset('storage/'.$course->cover_image)
                    : asset('images/about-hero-visual.svg'),
            ],
        ])->all(),
    ];
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)
@section('canonical_url', $canonicalUrl)
@section('og_type', 'website')
@section('og_image', asset('images/about-hero-visual.svg'))
@section('og_image_alt', __('courses.title'))
@section('twitter_image', asset('images/about-hero-visual.svg'))

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($coursesListSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    @php
        $currentLevel = request('level');
        $currentCategory = request('category');
        $currentSort = request('sort', 'featured');

        $sortOptions = [
            'featured' => __('courses.sort_featured'),
            'newest' => __('courses.sort_newest'),
            'popular' => __('courses.sort_popular'),
            'duration_asc' => __('courses.sort_duration_asc'),
            'duration_desc' => __('courses.sort_duration_desc'),
        ];

        if (! array_key_exists($currentSort, $sortOptions)) {
            $currentSort = 'featured';
        }

        $hasFilters = $currentLevel || $currentCategory || ($currentSort && $currentSort !== 'featured');

        $buildQuery = function (array $overrides = [], array $except = []): array {
            return collect(request()->except(array_merge(['page'], $except)))
                ->merge($overrides)
                ->filter(fn ($value) => $value !== null && $value !== '')
                ->all();
        };
    @endphp

    <section class="bg-white py-12 lg:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-5">
                <h1 class="font-display text-4xl text-charcoal lg:text-5xl">{{ __('courses.title') }}</h1>
                <p class="mt-2 text-charcoal/65">{{ __('courses.subtitle') }}</p>
            </div>

            <div id="coursesFilterBlock" class="relative mb-8 rounded-2xl border border-border bg-cream/60 p-4 shadow-sm lg:p-5">
                <div id="coursesFiltersLoading" class="invisible absolute inset-0 z-20 flex items-center justify-center rounded-2xl bg-white/80 opacity-0 backdrop-blur-[1px] transition-all duration-200">
                    <div class="inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-xs font-bold text-white shadow-md">
                        <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-30" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                            <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V1C6.925 1 3 4.925 3 10h1z"></path>
                        </svg>
                        <span>{{ __('courses.loading_filters') }}</span>
                    </div>
                </div>

                <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                    <span class="text-sm font-bold text-charcoal/80">{{ __('courses.filter_by_level') }}</span>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                            {{ __('courses.results_count', ['count' => $courses->total()]) }}
                        </span>
                        <a href="{{ route('courses.index') }}"
                            class="{{ $hasFilters ? 'border-border bg-white text-charcoal/75 hover:border-primary hover:text-primary' : 'pointer-events-none border-border/70 bg-white/70 text-charcoal/45' }} rounded-full border px-3 py-1 text-xs font-semibold transition">
                            {{ __('courses.reset_filters') }}
                        </a>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('courses.index', $buildQuery([], ['level'])) }}"
                        data-filter-link
                        class="{{ $currentLevel ? 'border-border bg-white text-charcoal hover:bg-primary/10' : 'border-primary bg-primary text-white shadow-sm' }} inline-flex items-center gap-1.5 rounded-full border px-4 py-2 text-sm font-semibold transition-all duration-200">
                        @if (! $currentLevel)
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif
                        {{ __('courses.all_levels') }}
                    </a>

                    @foreach (['beginner', 'intermediate', 'advanced'] as $level)
                        <a href="{{ route('courses.index', $buildQuery(['level' => $level], ['level'])) }}"
                            data-filter-link
                            class="{{ $currentLevel === $level ? 'border-primary bg-primary text-white shadow-sm' : 'border-border bg-white text-charcoal hover:bg-primary/10' }} inline-flex items-center gap-1.5 rounded-full border px-4 py-2 text-sm font-semibold transition-all duration-200">
                            @if ($currentLevel === $level)
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif
                            {{ __('levels.'.$level) }}
                        </a>
                    @endforeach
                </div>

                <form method="get" class="mt-4 grid gap-3 sm:grid-cols-2">
                    @if ($currentLevel)
                        <input type="hidden" name="level" value="{{ $currentLevel }}">
                    @endif

                    <div>
                        <label for="categoryFilter" class="text-sm font-bold text-charcoal/80">{{ __('courses.filter_by_category') }}</label>
                        <div class="relative mt-1">
                            <select id="categoryFilter"
                                    name="category"
                                    data-filter-select
                                    class="w-full appearance-none rounded-xl border-2 border-border bg-white px-4 py-2.5 pe-10 text-sm font-semibold text-charcoal shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/15">
                                <option value="">{{ __('courses.all_categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" @selected($currentCategory === $category->slug)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none absolute inset-y-0 end-3 my-auto h-4 w-4 text-charcoal/45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <label for="sortFilter" class="text-sm font-bold text-charcoal/80">{{ __('courses.sort_by') }}</label>
                        <div class="relative mt-1">
                            <select id="sortFilter"
                                    name="sort"
                                    data-filter-select
                                    class="w-full appearance-none rounded-xl border-2 border-border bg-white px-4 py-2.5 pe-10 text-sm font-semibold text-charcoal shadow-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/15">
                                @foreach ($sortOptions as $sortValue => $sortLabel)
                                    <option value="{{ $sortValue }}" @selected($currentSort === $sortValue)>
                                        {{ $sortLabel }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none absolute inset-y-0 end-3 my-auto h-4 w-4 text-charcoal/45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>

                    <noscript>
                        <button class="btn-secondary sm:col-span-2 text-sm">{{ __('courses.filter') }}</button>
                    </noscript>
                </form>

                @if ($hasFilters)
                    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-border/80 pt-3">
                        <span class="text-sm font-semibold text-charcoal/75">{{ __('courses.active_filters') }}:</span>

                        @if ($currentLevel)
                            <a href="{{ route('courses.index', $buildQuery([], ['level'])) }}"
                                data-filter-link
                                class="rounded-full bg-primary/10 px-3 py-1 text-sm font-semibold text-primary transition hover:bg-primary/20">
                                {{ __('levels.'.$currentLevel) }} x
                            </a>
                        @endif

                        @if ($currentCategory)
                            <a href="{{ route('courses.index', $buildQuery([], ['category'])) }}"
                                data-filter-link
                                class="rounded-full bg-primary/10 px-3 py-1 text-sm font-semibold text-primary transition hover:bg-primary/20">
                                {{ optional($categories->firstWhere('slug', $currentCategory))->name ?? $currentCategory }} x
                            </a>
                        @endif

                        @if ($currentSort && $currentSort !== 'featured')
                            <a href="{{ route('courses.index', $buildQuery([], ['sort'])) }}"
                                data-filter-link
                                class="rounded-full bg-accent/15 px-3 py-1 text-sm font-semibold text-accent transition hover:bg-accent/25">
                                {{ $sortOptions[$currentSort] ?? __('courses.sort_featured') }} x
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-7">
                @forelse ($courses as $course)
                    @php
                        $coverImage = $course->cover_image
                            ? asset('storage/'.$course->cover_image)
                            : 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&h=450&fit=crop&q=80';
                        $levelBadgeClasses = match ($course->level) {
                            'beginner' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                            'intermediate' => 'bg-amber-100 text-amber-700 ring-amber-200',
                            default => 'bg-accent/20 text-primary ring-accent/35',
                        };
                    @endphp

                    <article class="group relative overflow-hidden rounded-3xl border border-primary/10 bg-white shadow-[0_10px_26px_rgba(26,26,26,0.06)] transition-all duration-300 ease-out hover:-translate-y-1.5 hover:border-primary/25 hover:shadow-[0_26px_56px_rgba(10,77,64,0.20)]">
                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-primary to-accent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                        <a href="{{ route('courses.show', $course) }}" class="block">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $coverImage }}"
                                    alt="{{ $course->title }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy"
                                    decoding="async">
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-primary/75 via-primary/20 to-transparent opacity-75 transition-opacity duration-300 group-hover:opacity-90"></div>
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-bold ring-1 {{ $levelBadgeClasses }}">
                                        {{ __('levels.'.$course->level) }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <div class="p-6">
                            <h2 class="text-xl font-extrabold leading-snug text-charcoal transition-colors duration-300 group-hover:text-primary">
                                {{ $course->title }}
                            </h2>
                            <p class="mt-3 min-h-[3.25rem] text-sm leading-6 text-charcoal/70">{{ $course->excerpt }}</p>

                            <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                                <div class="inline-flex items-center gap-1.5 rounded-xl bg-cream px-3 py-2 font-semibold text-charcoal/80">
                                    <svg class="h-4 w-4 text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>{{ $course->lessons_count }} {{ __('courses.lessons') }}</span>
                                </div>
                                <div class="inline-flex items-center gap-1.5 rounded-xl bg-cream px-3 py-2 font-semibold text-charcoal/80">
                                    <svg class="h-4 w-4 text-primary/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $course->duration_minutes }} {{ __('courses.minutes') }}</span>
                                </div>
                            </div>

                            @if ($course->category)
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1.5 text-xs font-semibold text-primary/80">
                                        {{ $course->category->name }}
                                    </span>
                                </div>
                            @endif

                            <a href="{{ route('courses.show', $course) }}" class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-primary to-primaryLight px-4 py-3 text-sm font-bold text-white transition-all duration-300 hover:-translate-y-0.5 hover:from-primaryDark hover:to-primary hover:shadow-lg group-hover:to-accent">
                                {{ __('courses.details') }}
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h10m0 0-4-4m4 4-4 4"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-3xl border border-dashed border-primary/30 bg-cream/60 px-6 py-14 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-primary/10">
                            <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 9.75h4.5m-4.5 4.5h2.25M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 19.5z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-charcoal">{{ __('courses.empty_title') }}</h3>
                        <p class="mt-2 text-charcoal/65">{{ __('courses.no_results') }}</p>
                        <a href="{{ route('courses.index') }}" class="btn-secondary mt-6 inline-flex">{{ __('courses.reset_filters') }}</a>
                    </div>
                @endforelse
            </div>

            @if ($courses->hasPages())
                <div class="mt-10 space-y-4">
                    <p class="text-center text-sm text-charcoal/60">
                        {{ __('courses.pagination_summary', ['from' => $courses->firstItem(), 'to' => $courses->lastItem(), 'total' => $courses->total()]) }}
                    </p>
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterBlock = document.getElementById('coursesFilterBlock');
            const loadingOverlay = document.getElementById('coursesFiltersLoading');

            if (!filterBlock || !loadingOverlay) {
                return;
            }

            const showLoading = () => {
                loadingOverlay.classList.remove('invisible', 'opacity-0');
                loadingOverlay.classList.add('opacity-100');
            };

            filterBlock.querySelectorAll('[data-filter-link]').forEach((link) => {
                link.addEventListener('click', showLoading, { passive: true });
            });

            filterBlock.querySelectorAll('[data-filter-select]').forEach((select) => {
                select.addEventListener('change', () => {
                    showLoading();
                    select.form?.submit();
                });
            });
        });
    </script>
@endpush

