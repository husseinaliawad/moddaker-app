@extends('layouts.frontend')

@section('content')
    @php
        $locale = app()->getLocale();
        $heroBadge = data_get($hero, "badge.$locale");
        $heroTitle = data_get($hero, "title.$locale");
        $heroDescription = data_get($hero, "description.$locale");
        $ctaTitle = data_get($cta, "title.$locale");
        $ctaDescription = data_get($cta, "description.$locale");

        $heroBadge = filled($heroBadge) ? $heroBadge : __('home.hero_badge');
        $heroTitle = filled($heroTitle) ? $heroTitle : __('home.hero_title');
        $heroDescription = filled($heroDescription) ? $heroDescription : __('home.hero_description');
        $ctaTitle = filled($ctaTitle) ? $ctaTitle : __('home.cta_title');
        $ctaDescription = filled($ctaDescription) ? $ctaDescription : __('home.cta_description');

        $fallbackVisuals = [
            'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?w=1200&h=900&fit=crop&q=80',
            'https://images.unsplash.com/photo-1585036156171-384164a8c675?w=1200&h=900&fit=crop&q=80',
            'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1200&h=900&fit=crop&q=80',
        ];

        $heroVisuals = collect();
        foreach ($courses->take(3) as $course) {
            if ($course->cover_image) {
                $heroVisuals->push(asset('storage/'.$course->cover_image));
            }
        }

        while ($heroVisuals->count() < 3) {
            $heroVisuals->push($fallbackVisuals[$heroVisuals->count()]);
        }

        $metaTitle = \Illuminate\Support\Str::limit(__('app.site_name').' | '.__('home.start_learning'), 60, '');
        $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($heroDescription)), 155, '');
        $metaKeywords = $locale === 'ar'
            ? 'تفسير القرآن, دورات قرآنية, تعلم القرآن أونلاين, منصة مدكر'
            : 'Quran tafsir courses, online Quran learning, Islamic studies platform, Moddaker';
        $metaImage = $heroVisuals->first() ?? asset('images/moddaker-logo.svg');

        $homeSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => route('home').'#organization',
                    'name' => __('app.site_name'),
                    'url' => route('home'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/moddaker-logo.svg'),
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => route('home').'#website',
                    'url' => route('home'),
                    'name' => __('app.site_name'),
                    'inLanguage' => str_replace('_', '-', $locale),
                    'publisher' => [
                        '@id' => route('home').'#organization',
                    ],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => route('courses.index').'?q={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
            ],
        ];
    @endphp

    @section('meta_title', $metaTitle)
    @section('meta_description', $metaDescription)
    @section('meta_keywords', $metaKeywords)
    @section('canonical_url', route('home'))
    @section('og_type', 'website')
    @section('og_image', $metaImage)
    @section('og_image_alt', $heroTitle)
    @section('twitter_image', $metaImage)

    @push('structured-data')
        <script type="application/ld+json">
            {!! json_encode($homeSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endpush

    <section class="relative flex min-h-[calc(100vh-5rem)] items-center overflow-hidden px-4 pb-8 pt-8 sm:px-6 lg:px-8 lg:pb-12 lg:pt-12">
        <div class="pointer-events-none absolute inset-0 hero-pattern-bg"></div>
        <div class="hero-ornament -start-20 -top-20 opacity-60 hero-float"></div>
        <div class="hero-ornament -end-20 bottom-10 opacity-60 hero-float" style="animation-delay: -3s;"></div>

        <div class="relative mx-auto max-w-7xl">
            <div class="grid items-center gap-8 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:gap-14">
                <div class="text-center lg:text-start">
                    <span class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-4 py-2 text-sm font-semibold text-primary">
                        <span class="h-2 w-2 rounded-full bg-accent"></span>
                        {{ $heroBadge }}
                    </span>

                    <h1 class="font-display mt-6 text-4xl leading-tight text-charcoal sm:text-5xl lg:text-6xl">
                        {{ $heroTitle }}
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-charcoal/75 sm:text-lg lg:mx-0">
                        {{ $heroDescription }}
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="hero-btn-primary inline-flex min-h-12 items-center justify-center rounded-xl px-7 text-base font-bold text-white">
                            {{ __('home.start_free') }}
                        </a>
                        <a href="{{ route('courses.index') }}" class="hero-btn-secondary inline-flex min-h-12 items-center justify-center rounded-xl px-7 text-base font-bold">
                            {{ __('home.browse_courses') }}
                        </a>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-md lg:max-w-lg">
                    <div class="relative rounded-3xl bg-white p-7 shadow-[0_30px_60px_rgba(10,77,64,0.16)] sm:p-9">
                        <div class="absolute start-0 top-0 h-24 w-24 rounded-bl-3xl rounded-tr-3xl bg-gradient-to-br from-accent/25 to-transparent"></div>

                        <div class="relative">
                            <div class="mb-6 text-center">
                                <p class="mb-3 inline-flex rounded-full bg-primary/10 px-4 py-1 text-sm font-semibold text-primary">
                                    {{ __('home.last_studied_lesson') }}
                                </p>
                                <h3 class="font-display text-2xl text-charcoal">{{ __('home.demo_surah_title') }}</h3>
                                <p class="text-sm text-charcoal/60">{{ __('home.demo_surah_verses') }}</p>
                            </div>

                            <div class="mb-6 rounded-2xl bg-creamDark p-4">
                                <div class="mb-2 flex items-center justify-between text-sm">
                                    <span class="text-charcoal/70">{{ __('home.course_progress') }}</span>
                                    <span class="font-bold text-primary">65%</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-white">
                                    <div class="hero-progress h-full rounded-full" style="width: 65%"></div>
                                </div>
                            </div>

                            <a href="{{ route('courses.index') }}" class="hero-btn-primary inline-flex min-h-11 w-full items-center justify-center rounded-xl text-sm font-bold text-white">
                                {{ __('home.continue_learning') }}
                            </a>
                        </div>
                    </div>

                    <div class="absolute -end-4 -top-4 rounded-xl bg-accent p-3 text-white shadow-lg hero-float">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <div class="absolute -bottom-4 -start-4 rounded-xl bg-primary p-3 text-white shadow-lg hero-float" style="animation-delay: -2s;">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="courses" class="px-4 pb-12 sm:px-6 lg:px-8 lg:pb-16">
        <div class="mx-auto max-w-7xl">
            <div class="mb-5 flex items-end justify-between gap-3">
                <div>
                    <span class="inline-flex items-center rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent">{{ __('home.available_courses') }}</span>
                    <h2 class="mt-2 text-2xl font-bold text-charcoal sm:text-3xl">{{ __('home.start_learning') }}</h2>
                </div>

                <a href="{{ route('courses.index') }}" class="hidden text-sm font-semibold text-primary sm:inline-flex">
                    {{ __('home.view_all_courses') }}
                </a>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 lg:gap-4">
                @forelse ($courses as $course)
                    @php
                        $coverImage = $course->cover_image
                            ? asset('storage/'.$course->cover_image)
                            : 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&h=450&fit=crop&q=80';
                        $levelBadgeClasses = match ($course->level) {
                            'beginner' => 'bg-emerald-100 text-emerald-700',
                            'intermediate' => 'bg-amber-100 text-amber-700',
                            default => 'bg-accent/20 text-primary',
                        };
                    @endphp

                    <article class="group overflow-hidden rounded-2xl border border-border/70 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="relative h-40 overflow-hidden">
                            <img src="{{ $coverImage }}" alt="{{ $course->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                            <span class="absolute end-3 top-3 inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold {{ $levelBadgeClasses }}">
                                {{ __('levels.'.$course->level) }}
                            </span>
                        </div>

                        <div class="p-4">
                            <h3 class="max-h-14 overflow-hidden text-base font-bold leading-7 text-charcoal">{{ $course->title }}</h3>
                            <p class="mt-2 max-h-14 overflow-hidden text-sm leading-7 text-charcoal/65">{{ $course->excerpt }}</p>

                            <div class="mt-3 flex flex-wrap items-center gap-1.5 text-[11px] font-semibold text-charcoal/65">
                                <span class="rounded-full bg-cream px-2.5 py-1">{{ $course->lessons_count }} {{ __('home.lessons') }}</span>
                                @if ($course->category)
                                    <span class="rounded-full bg-primary/10 px-2.5 py-1 text-primary">{{ $course->category->name }}</span>
                                @endif
                            </div>

                            <a href="{{ route('courses.show', $course) }}" class="mt-4 inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-primary px-4 text-sm font-bold text-white transition hover:bg-primaryDark">
                                {{ __('home.view_course') }}
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-2xl border border-dashed border-border bg-white/80 p-6 text-center text-sm text-charcoal/60">
                        {{ __('home.no_courses') }}
                    </p>
                @endforelse
            </div>

            <div class="mt-4 sm:hidden">
                <a href="{{ route('courses.index') }}" class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-border bg-white text-sm font-semibold text-charcoal/85">
                    {{ __('home.view_all_courses') }}
                </a>
            </div>
        </div>
    </section>

    <section class="px-4 pb-16 sm:px-6 lg:px-8 lg:pb-20">
        <div class="mx-auto max-w-7xl">
            <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-primary to-primaryLight px-5 py-8 text-white sm:px-8 sm:py-10">
                <div class="pointer-events-none absolute -end-10 -top-10 h-36 w-36 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -start-10 bottom-0 h-32 w-32 rounded-full bg-accent/20 blur-2xl"></div>

                <div class="relative">
                    <h2 class="font-display text-3xl leading-tight sm:text-4xl">{{ $ctaTitle }}</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-white/85 sm:text-base">{{ $ctaDescription }}</p>

                    <div class="mt-6 grid grid-cols-1 gap-2.5 sm:grid-cols-2 sm:max-w-xl">
                        <a href="{{ route('register') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl bg-white px-5 text-sm font-bold text-primary transition hover:bg-cream">
                            {{ __('home.start_free') }}
                        </a>
                        <a href="{{ route('courses.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-white/35 px-5 text-sm font-bold text-white transition hover:bg-white/10">
                            {{ __('home.browse_courses') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
