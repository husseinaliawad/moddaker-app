@extends('layouts.frontend')

@php
    $aboutTranslation = $page?->translation(app()->getLocale()) ?? $page?->translation();
    $aboutTitle = data_get($aboutTranslation, 'title') ?: __('about.title');
    $aboutExcerpt = data_get($aboutTranslation, 'excerpt') ?: __('about.hero_description');

    $metaTitle = \Illuminate\Support\Str::limit($aboutTitle.' | '.__('app.site_name'), 60, '');
    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($aboutExcerpt)), 155, '');
    $metaKeywords = app()->getLocale() === 'ar'
        ? 'عن منصة مدكر, تفسير القرآن, منهج تعليمي, التعلم الإسلامي'
        : 'About Moddaker, Quran tafsir platform, Islamic learning methodology';

    $aboutSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => $aboutTitle,
        'description' => \Illuminate\Support\Str::limit(trim(strip_tags($aboutExcerpt)), 220, ''),
        'url' => route('about'),
        'inLanguage' => str_replace('_', '-', app()->getLocale()),
    ];
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)
@section('canonical_url', route('about'))
@section('og_type', 'website')
@section('og_image', asset('images/about-hero-visual.svg'))
@section('og_image_alt', $aboutTitle)
@section('twitter_image', asset('images/about-hero-visual.svg'))

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($aboutSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    @php
        $locale = app()->getLocale();
        $translation = $page?->translation($locale) ?? $page?->translation();

        $heroTitle = data_get($translation, 'title') ?: __('about.title');
        $heroDescription = data_get($translation, 'excerpt') ?: __('about.hero_description');
        $aboutDescription = trim(strip_tags((string) (data_get($translation, 'content') ?: __('about.content'))));

        $primaryCtaUrl = auth()->check()
            ? (auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('student.dashboard'))
            : route('register');
        $primaryCtaLabel = auth()->check() ? __('nav.dashboard') : __('about.cta_primary');

        $normalizeStatValue = static fn ($value): int => (int) preg_replace('/[^\d]/', '', (string) $value);
        $studentsCount = $normalizeStatValue(data_get($stats, '0.value', 0));
        $coursesCount = $normalizeStatValue(data_get($stats, '1.value', 0));
        $lessonsCount = $normalizeStatValue(data_get($stats, '2.value', 0));

        $heroStats = collect([
            [
                'value' => $studentsCount,
                'label' => __('about.stat_students'),
                'icon' => 'users',
            ],
            [
                'value' => $coursesCount,
                'label' => __('about.stat_courses'),
                'icon' => 'courses',
            ],
            [
                'value' => $lessonsCount,
                'label' => __('about.stat_lessons'),
                'icon' => 'lessons',
            ],
            [
                'value' => max((int) $certificatesCount, 1),
                'label' => __('about.stat_certificates'),
                'icon' => 'certificates',
            ],
        ]);

        $featureIcons = ['shield', 'chart', 'instructors', 'trend-up'];

        $features = [
            ['title' => __('about.feature_1_title'), 'description' => __('about.feature_1_description')],
            ['title' => __('about.feature_2_title'), 'description' => __('about.feature_2_description')],
            ['title' => __('about.feature_3_title'), 'description' => __('about.feature_3_description')],
            ['title' => __('about.feature_4_title'), 'description' => __('about.feature_4_description')],
        ];
    @endphp

    <section class="relative overflow-hidden px-4 pb-20 pt-6 sm:px-6 lg:px-8 lg:pb-24 lg:pt-10">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-[34rem] bg-gradient-to-b from-primary/15 via-accent/5 to-transparent"></div>
        <div class="pointer-events-none absolute -start-20 top-6 h-64 w-64 rounded-full bg-primary/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -end-20 top-16 h-64 w-64 rounded-full bg-accent/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl">
            <div class="relative overflow-hidden rounded-[2rem] border border-white/40 bg-gradient-to-br from-[#0b6658] via-primary to-[#0a4d40] px-5 py-6 text-white shadow-[0_30px_70px_-42px_rgba(20,12,22,0.95)] sm:px-7 sm:py-8 lg:px-10 lg:py-10">
                <div class="pointer-events-none absolute inset-0 opacity-15 [background-size:16px_16px] [background-image:radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.8)_1px,transparent_0)]"></div>
                <div class="pointer-events-none absolute -top-16 -end-16 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-20 -start-10 h-56 w-56 rounded-full bg-accent/30 blur-3xl"></div>

                <div class="relative grid gap-7 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:items-center lg:gap-10">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-xs font-semibold">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#ffd9c8]"></span>
                            {{ __('about.badge') }}
                        </span>

                        <h1 class="font-display mt-4 text-[2rem] leading-[1.2] sm:text-5xl lg:text-6xl">
                            {{ $heroTitle }}
                        </h1>

                        <p class="mt-4 max-w-xl text-sm leading-8 text-white/90 sm:text-base">
                            {{ $heroDescription }}
                        </p>

                        <div class="mt-6 grid grid-cols-1 gap-2.5 sm:grid-cols-2 sm:gap-3">
                            <a href="{{ $primaryCtaUrl }}" class="inline-flex min-h-12 items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-bold text-primary shadow-[0_20px_28px_-18px_rgba(255,255,255,0.95)] transition hover:-translate-y-0.5 hover:bg-cream">
                                {{ $primaryCtaLabel }}
                            </a>
                            <a href="{{ route('courses.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-white/35 bg-white/5 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/15">
                                {{ __('about.cta_secondary') }}
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="rounded-[1.6rem] border border-white/20 bg-white/10 p-3 backdrop-blur-sm sm:p-4">
                            <article class="rounded-2xl border border-slate-200/70 bg-white p-4 text-charcoal shadow-[0_20px_40px_-32px_rgba(16,24,40,0.6)] sm:p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                                        {{ __('about.badge') }}
                                    </span>
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                        <x-admin.icon name="courses" class="h-4 w-4" />
                                    </span>
                                </div>

                                <h3 class="mt-4 text-base font-bold text-charcoal sm:text-lg">
                                    {{ __('about.cta_secondary') }}
                                </h3>

                                <div class="mt-4 space-y-3">
                                    <div class="h-2 rounded-full bg-slate-100">
                                        <div class="h-full w-4/5 rounded-full bg-primary/45"></div>
                                    </div>
                                    <div class="h-2 rounded-full bg-slate-100">
                                        <div class="h-full w-3/5 rounded-full bg-primary/35"></div>
                                    </div>
                                    <div class="h-2 rounded-full bg-slate-100">
                                        <div class="h-full w-2/3 rounded-full bg-primary/25"></div>
                                    </div>
                                </div>

                                <div class="mt-5 rounded-xl border border-primary/20 bg-primary/5 px-4 py-3">
                                    <p class="text-xs font-semibold text-primary">{{ __('about.certificate_hint') }}</p>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-2.5">
                                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                                        <p class="text-[11px] font-semibold text-charcoal/55">{{ __('about.stat_courses') }}</p>
                                        <p class="font-display mt-1 text-lg leading-none text-charcoal">+{{ number_format($coursesCount) }}</p>
                                    </div>
                                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                                        <p class="text-[11px] font-semibold text-charcoal/55">{{ __('about.stat_lessons') }}</p>
                                        <p class="font-display mt-1 text-lg leading-none text-charcoal">+{{ number_format($lessonsCount) }}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative px-4 pb-12 sm:px-6 lg:px-8 lg:pb-14">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-[1.9rem] border border-border/80 bg-white/95 p-5 shadow-[0_22px_45px_-34px_rgba(17,22,35,0.4)] sm:p-7">
                <div class="flex flex-col gap-1">
                    <span class="inline-flex w-fit rounded-full border border-primary/15 bg-primary/5 px-3 py-1 text-xs font-semibold text-primary">
                        {{ __('about.trust_badge') }}
                    </span>
                    <h2 class="font-display text-2xl text-charcoal sm:text-3xl">
                        {{ __('about.trust_title') }}
                    </h2>
                    <p class="text-sm leading-7 text-charcoal/70 sm:text-base">
                        {{ __('about.trust_subtitle') }}
                    </p>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                    @foreach ($heroStats as $stat)
                        <article class="group relative overflow-hidden rounded-2xl border border-border/80 bg-white p-4 shadow-[0_14px_30px_-24px_rgba(24,16,28,0.45)] transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_20px_30px_-20px_rgba(24,16,28,0.35)]">
                            <div class="pointer-events-none absolute -end-6 -top-6 h-20 w-20 rounded-full bg-primary/10 blur-2xl transition group-hover:bg-accent/15"></div>

                            <span class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl border border-primary/10 bg-gradient-to-br from-primary/10 to-accent/10 text-primary">
                                <x-admin.icon :name="data_get($stat, 'icon', 'chart')" class="h-4 w-4" />
                            </span>

                            <p class="mt-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-charcoal/55">
                                {{ data_get($stat, 'label') }}
                            </p>
                            <p class="font-display mt-1 text-3xl leading-none text-primary">
                                +{{ number_format((int) data_get($stat, 'value', 0)) }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden px-4 pb-12 sm:px-6 lg:px-8 lg:pb-16">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-52 bg-gradient-to-b from-white/65 to-transparent"></div>

        <div class="relative mx-auto max-w-7xl">
            <div class="grid gap-4 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:items-start">
                <article class="rounded-[1.9rem] border border-border/80 bg-white p-5 shadow-[0_20px_45px_-32px_rgba(18,10,18,0.6)] sm:p-7">
                    <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                        {{ __('about.story_badge') }}
                    </span>

                    <h2 class="font-display mt-4 text-3xl leading-tight text-charcoal sm:text-4xl">
                        {{ __('about.story_title') }}
                    </h2>

                    <p class="mt-4 text-sm leading-8 text-charcoal/75 sm:text-base">
                        {{ $aboutDescription }}
                    </p>

                    <p class="mt-3 text-sm leading-8 text-charcoal/70 sm:text-base">
                        {{ __('about.story_paragraph_2') }}
                    </p>

                    <div class="mt-5 rounded-2xl border border-primary/10 bg-gradient-to-b from-primary/5 to-accent/5 p-4">
                        <p class="font-display text-xl text-primary">"{{ __('about.quote') }}"</p>
                        <p class="mt-2 text-xs font-semibold text-charcoal/55">{{ __('about.quote_source') }}</p>
                    </div>
                </article>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach ($features as $feature)
                        <article class="group rounded-2xl border border-border/80 bg-white/90 p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-primary/20 hover:shadow-md">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-primary/15 bg-primary/5 text-primary">
                                <x-admin.icon :name="$featureIcons[$loop->index] ?? 'spark'" class="h-4 w-4" />
                            </span>

                            <h3 class="mt-3 text-sm font-bold text-charcoal sm:text-base">
                                {{ $feature['title'] }}
                            </h3>

                            <p class="mt-2 text-xs leading-7 text-charcoal/65 sm:text-sm">
                                {{ $feature['description'] }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 pb-16 sm:px-6 lg:px-8 lg:pb-20">
        <div class="mx-auto max-w-7xl">
            <div class="relative overflow-hidden rounded-[2rem] border border-primary/20 bg-white p-5 shadow-[0_24px_50px_-36px_rgba(22,12,22,0.7)] sm:p-7">
                <div class="pointer-events-none absolute inset-y-0 end-0 w-1/2 bg-gradient-to-s from-accent/10 to-transparent"></div>
                <div class="pointer-events-none absolute -start-16 bottom-0 h-44 w-44 rounded-full bg-primary/10 blur-3xl"></div>

                <div class="relative">
                    <h2 class="font-display text-3xl text-charcoal sm:text-4xl">{{ __('about.final_title') }}</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-8 text-charcoal/70 sm:text-base">
                        {{ __('about.final_description') }}
                    </p>

                    <div class="mt-6 grid grid-cols-1 gap-2.5 sm:grid-cols-3 sm:gap-3">
                        <a href="{{ route('register') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl bg-primary px-5 text-sm font-bold text-white shadow-[0_18px_30px_-18px_rgba(10,77,64,0.85)] transition hover:-translate-y-0.5 hover:bg-primaryDark">
                            {{ __('about.cta_primary') }}
                        </a>
                        <a href="{{ route('courses.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-border bg-white px-5 text-sm font-bold text-charcoal/85 transition hover:bg-cream">
                            {{ __('about.cta_secondary') }}
                        </a>
                        <a href="{{ route('contact.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-primary/20 bg-primary/5 px-5 text-sm font-bold text-primary transition hover:bg-primary/10">
                            {{ __('about.cta_contact') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

