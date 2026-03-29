@extends('layouts.frontend')

@php
    $faqTitle = $page?->title ?? __('faq.title');
    $faqDescription = $page?->excerpt ?? __('faq.subtitle');
    $metaTitle = \Illuminate\Support\Str::limit($faqTitle.' | '.__('app.site_name'), 60, '');
    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($faqDescription)), 155, '');
    $metaKeywords = app()->getLocale() === 'ar'
        ? 'الأسئلة الشائعة, دورات القرآن, منصة مدكر, الدعم التعليمي'
        : 'FAQ, Quran courses questions, Moddaker support, online learning help';

    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($faqs)->map(fn (array $faq) => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ])->values()->all(),
    ];
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)
@section('canonical_url', route('faq'))
@section('og_type', 'website')
@section('og_image', asset('images/moddaker-logo.svg'))
@section('og_image_alt', $faqTitle)
@section('twitter_image', asset('images/moddaker-logo.svg'))

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    <section class="relative overflow-hidden px-4 pb-14 pt-3 sm:px-6 lg:px-8 lg:pb-16">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-64 bg-gradient-to-b from-primary/12 via-accent/5 to-transparent"></div>
        <div class="pointer-events-none absolute -start-20 top-4 h-48 w-48 rounded-full bg-primary/12 blur-3xl"></div>
        <div class="pointer-events-none absolute -end-16 top-20 h-44 w-44 rounded-full bg-accent/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-5xl">
            <div class="overflow-hidden rounded-3xl border border-border/70 bg-white/90 p-4 shadow-[0_18px_40px_-30px_rgba(22,12,22,0.65)] backdrop-blur sm:p-6">
                <div class="pointer-events-none absolute -end-14 -top-16 h-36 w-36 rounded-full bg-primary/10 blur-3xl"></div>

                <div class="relative">
                    <span class="inline-flex items-center rounded-full border border-primary/15 bg-primary/5 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-primary">
                        {{ __('faq.badge') }}
                    </span>

                    <h1 class="font-display mt-3 text-3xl leading-tight text-charcoal sm:text-4xl">
                        {{ $page?->title ?? __('faq.title') }}
                    </h1>

                    <p class="mt-2 text-sm leading-7 text-charcoal/70 sm:text-base">
                        {{ $page?->excerpt ?? __('faq.subtitle') }}
                    </p>

                    <div class="mt-4">
                        <label for="faqSearch" class="mb-2 block text-xs font-bold uppercase tracking-[0.1em] text-charcoal/60">
                            {{ __('faq.search_label') }}
                        </label>
                        <div class="relative">
                            <input
                                id="faqSearch"
                                type="search"
                                placeholder="{{ __('faq.search_placeholder') }}"
                                class="h-12 w-full rounded-2xl border border-border bg-white px-4 ps-11 text-sm font-medium text-charcoal shadow-sm transition placeholder:text-charcoal/40 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                            >
                            <svg class="pointer-events-none absolute start-4 top-1/2 h-5 w-5 -translate-y-1/2 text-charcoal/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <p class="mt-2 text-xs text-charcoal/55">{{ __('faq.search_hint') }}</p>
                    </div>
                </div>
            </div>

            <div id="faqList" class="mt-4 space-y-3">
                @foreach ($faqs as $faq)
                    <details
                        class="faq-item group overflow-hidden rounded-2xl border border-border/80 bg-white shadow-sm transition duration-200 hover:border-primary/25 hover:shadow-md open:border-primary/30 open:shadow-md"
                        @if ($loop->first) open @endif
                        data-faq-item
                    >
                        <summary class="flex min-h-14 cursor-pointer list-none items-center justify-between gap-3 px-4 py-3.5 sm:px-5 sm:py-4">
                            <h2 class="text-sm font-bold leading-7 text-charcoal sm:text-base" data-faq-question>{{ $faq['question'] }}</h2>
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-primary/10 bg-primary/5 text-primary transition group-open:bg-primary group-open:text-white">
                                <svg class="h-4 w-4 transition-transform duration-300 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </span>
                        </summary>

                        <div class="border-t border-border/70 px-4 pb-4 pt-3 sm:px-5 sm:pb-5">
                            <p class="text-sm leading-8 text-charcoal/75 sm:text-base" data-faq-answer>{{ $faq['answer'] }}</p>
                        </div>
                    </details>
                @endforeach
            </div>

            <div id="faqEmptyState" class="mt-4 hidden rounded-2xl border border-dashed border-primary/35 bg-white/85 p-6 text-center sm:p-8">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-5-8H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V9m-5-5v5m0 0h5"/>
                    </svg>
                </div>
                <h3 class="mt-3 text-lg font-bold text-charcoal sm:text-xl">{{ __('faq.no_results_title') }}</h3>
                <p class="mt-2 text-sm leading-7 text-charcoal/65 sm:text-base">{{ __('faq.no_results_text') }}</p>
                <a href="{{ route('contact.create') }}" class="mt-4 inline-flex min-h-11 items-center justify-center rounded-xl border border-border bg-white px-5 text-sm font-semibold text-charcoal transition hover:border-primary/25 hover:text-primary">
                    {{ __('faq.contact_cta') }}
                </a>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-primary/15 bg-gradient-to-br from-primary/8 via-white to-accent/10 p-5 shadow-sm sm:p-7">
                <h3 class="font-display text-2xl text-charcoal sm:text-3xl">{{ __('faq.need_help_title') }}</h3>
                <p class="mt-2 max-w-2xl text-sm leading-7 text-charcoal/70 sm:text-base">{{ __('faq.need_help_text') }}</p>

                <div class="mt-5 grid grid-cols-1 gap-2.5 sm:grid-cols-2 sm:gap-3">
                    <a href="{{ route('contact.create') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl bg-primary px-5 text-sm font-bold text-white shadow-[0_16px_28px_-20px_rgba(10,77,64,0.85)] transition hover:-translate-y-0.5 hover:bg-primaryDark">
                        {{ __('faq.contact_cta') }}
                    </a>
                    <a href="{{ route('courses.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-xl border border-border bg-white px-5 text-sm font-bold text-charcoal/85 transition hover:bg-cream">
                        {{ __('faq.start_cta') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('faqSearch');
            const items = Array.from(document.querySelectorAll('[data-faq-item]'));
            const emptyState = document.getElementById('faqEmptyState');

            if (!searchInput || !items.length || !emptyState) {
                return;
            }

            const normalize = (value) => value.toLowerCase().trim();

            searchInput.addEventListener('input', () => {
                const term = normalize(searchInput.value);
                let visibleCount = 0;

                items.forEach((item) => {
                    const question = normalize(item.querySelector('[data-faq-question]')?.textContent ?? '');
                    const answer = normalize(item.querySelector('[data-faq-answer]')?.textContent ?? '');
                    const isMatch = term === '' || question.includes(term) || answer.includes(term);

                    item.classList.toggle('hidden', !isMatch);
                    if (isMatch) {
                        visibleCount += 1;
                    }
                });

                emptyState.classList.toggle('hidden', visibleCount > 0);
            });
        });
    </script>
@endpush

