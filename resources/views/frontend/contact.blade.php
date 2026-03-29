@extends('layouts.frontend')

@php
    $contactTitle = __('contact.title');
    $contactDescription = __('contact.subtitle');
    $metaTitle = \Illuminate\Support\Str::limit($contactTitle.' | '.__('app.site_name'), 60, '');
    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($contactDescription)), 155, '');
    $metaKeywords = app()->getLocale() === 'ar'
        ? 'اتصل بنا, دعم منصة مدكر, استفسارات الدورات, التواصل التعليمي'
        : 'Contact Moddaker, support team, Quran course inquiries, learning help';

    $contactSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => $contactTitle,
        'description' => \Illuminate\Support\Str::limit(trim(strip_tags($contactDescription)), 220, ''),
        'url' => route('contact.create'),
        'inLanguage' => str_replace('_', '-', app()->getLocale()),
    ];
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@section('meta_keywords', $metaKeywords)
@section('canonical_url', route('contact.create'))
@section('og_type', 'website')
@section('og_image', asset('images/moddaker-logo.svg'))
@section('og_image_alt', $contactTitle)
@section('twitter_image', asset('images/moddaker-logo.svg'))

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($contactSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    @php
        $locale = app()->getLocale();
        $address = data_get($contactInfo, "address.$locale", data_get($contactInfo, 'address.ar'));
        $phoneRaw = (string) data_get($contactInfo, 'phone');
        $phoneHref = preg_replace('/\s+/', '', $phoneRaw);
    @endphp

    <section class="relative overflow-hidden px-4 pb-14 pt-4 sm:px-6 lg:px-8 lg:pb-16">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-primary/12 via-accent/6 to-transparent"></div>
        <div class="pointer-events-none absolute -start-20 top-8 h-56 w-56 rounded-full bg-primary/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -end-20 top-20 h-52 w-52 rounded-full bg-accent/15 blur-3xl"></div>

        <div class="relative mx-auto max-w-5xl">
            <header class="relative overflow-hidden rounded-[1.9rem] border border-white/50 bg-white/85 p-5 shadow-[0_22px_44px_-30px_rgba(20,12,22,0.65)] backdrop-blur sm:p-7">
                <div class="pointer-events-none absolute inset-0 opacity-20 [background-size:15px_15px] [background-image:radial-gradient(circle_at_1px_1px,rgba(10,77,64,0.24)_1px,transparent_0)]"></div>
                <div class="relative">
                    <span class="inline-flex items-center rounded-full border border-primary/15 bg-primary/8 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.12em] text-primary">
                        {{ __('contact.title') }}
                    </span>
                    <h1 class="font-display mt-3 text-3xl leading-tight text-charcoal sm:text-4xl">
                        {{ __('contact.title') }}
                    </h1>
                    <p class="mt-2 max-w-2xl text-sm leading-7 text-charcoal/70 sm:text-base">
                        {{ __('contact.subtitle') }}
                    </p>
                </div>
            </header>

            <div class="mt-4 grid gap-4 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] lg:items-start">
                <form
                    x-data="{ submitting: false }"
                    @submit="submitting = true"
                    action="{{ route('contact.store') }}"
                    method="post"
                    aria-label="{{ app()->getLocale() === 'ar' ? 'نموذج التواصل' : 'Contact form' }}"
                    class="order-1 rounded-[1.75rem] border border-border/70 bg-white p-5 shadow-[0_20px_42px_-34px_rgba(20,12,22,0.62)] sm:p-6"
                >
                    @csrf

                    <div class="grid gap-3 sm:grid-cols-2 sm:gap-4">
                        <div>
                            <label for="contactName" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/65">
                                {{ __('contact.name') }}
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 start-0 flex w-11 items-center justify-center text-charcoal/35">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8a7 7 0 0 0-14 0"/>
                                    </svg>
                                </span>
                                <input id="contactName" type="text" name="name" value="{{ old('name') }}" autocomplete="name" class="h-12 w-full rounded-xl border border-border bg-white px-4 ps-11 text-sm font-medium text-charcoal shadow-sm transition placeholder:text-charcoal/35 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10" required aria-required="true">
                            </div>
                            @error('name')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contactEmail" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/65">
                                {{ __('contact.email') }}
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 start-0 flex w-11 items-center justify-center text-charcoal/35">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="m4 7 8 5 8-5m-14 11h12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2Z"/>
                                    </svg>
                                </span>
                                <input id="contactEmail" type="email" name="email" value="{{ old('email') }}" autocomplete="email" class="h-12 w-full rounded-xl border border-border bg-white px-4 ps-11 text-sm font-medium text-charcoal shadow-sm transition placeholder:text-charcoal/35 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10" required aria-required="true">
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 sm:mt-4">
                        <label for="contactPhone" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/65">
                            {{ __('contact.phone') }}
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex w-11 items-center justify-center text-charcoal/35">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M6.75 3.75h3l1.5 3.75-1.9 1.9a14.2 14.2 0 0 0 5.25 5.25l1.9-1.9 3.75 1.5v3A1.5 1.5 0 0 1 18.75 20C10.6 20 4 13.4 4 5.25a1.5 1.5 0 0 1 2.75-1.5Z"/>
                                </svg>
                            </span>
                            <input id="contactPhone" type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="h-12 w-full rounded-xl border border-border bg-white px-4 ps-11 text-sm font-medium text-charcoal shadow-sm transition placeholder:text-charcoal/35 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-3 sm:mt-4">
                        <label for="contactSubject" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/65">
                            {{ __('contact.subject') }}
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex w-11 items-center justify-center text-charcoal/35">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M5.75 6.75h12.5M5.75 11.75h12.5M5.75 16.75h7.5"/>
                                </svg>
                            </span>
                            <input id="contactSubject" type="text" name="subject" value="{{ old('subject') }}" autocomplete="off" class="h-12 w-full rounded-xl border border-border bg-white px-4 ps-11 text-sm font-medium text-charcoal shadow-sm transition placeholder:text-charcoal/35 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10" required aria-required="true">
                        </div>
                        @error('subject')
                            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-3 sm:mt-4">
                        <label for="contactMessage" class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/65">
                            {{ __('contact.message') }}
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute start-0 top-3.5 flex w-11 items-start justify-center text-charcoal/35">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M4.75 6.75A2.75 2.75 0 0 1 7.5 4h9A2.75 2.75 0 0 1 19.25 6.75v10.5A2.75 2.75 0 0 1 16.5 20h-9a2.75 2.75 0 0 1-2.75-2.75V6.75Z"/>
                                </svg>
                            </span>
                            <textarea id="contactMessage" name="message" rows="7" autocomplete="off" class="w-full rounded-xl border border-border bg-white px-4 py-3 ps-11 text-sm leading-7 text-charcoal shadow-sm transition placeholder:text-charcoal/35 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10" required aria-required="true">{{ old('message') }}</textarea>
                        </div>
                        @error('message')
                            <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-4 inline-flex min-h-12 w-full items-center justify-center rounded-xl bg-primary px-6 text-sm font-bold text-white shadow-[0_20px_28px_-18px_rgba(10,77,64,0.88)] transition hover:-translate-y-0.5 hover:bg-primaryDark active:translate-y-0 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70"
                        :disabled="submitting"
                        aria-label="{{ __('contact.send') }}"
                    >
                        <span x-show="!submitting">{{ __('contact.send') }}</span>
                        <span x-show="submitting" x-cloak class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity="0.3" stroke-width="3"></circle>
                                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                            </svg>
                            <span>{{ __('contact.send') }}</span>
                        </span>
                    </button>
                </form>

                <aside class="order-2 rounded-[1.75rem] border border-border/70 bg-white/92 p-5 shadow-[0_20px_42px_-34px_rgba(20,12,22,0.58)] sm:p-6">
                    <h2 class="text-lg font-bold text-charcoal">{{ __('contact.title') }}</h2>
                    <p class="mt-1 text-sm leading-7 text-charcoal/65">
                        {{ __('contact.subtitle') }}
                    </p>

                    <div class="mt-4 space-y-2.5">
                        <a href="mailto:{{ data_get($contactInfo, 'email') }}" class="flex min-h-14 items-center gap-3 rounded-xl border border-border bg-white px-3.5 py-3 transition hover:border-primary/20 hover:bg-primary/5" aria-label="{{ __('contact.email') }}: {{ data_get($contactInfo, 'email') }}">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="m4 7 8 5 8-5m-14 11h12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2Z"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/55">{{ __('contact.email') }}</p>
                                <p class="truncate text-sm font-semibold text-charcoal">{{ data_get($contactInfo, 'email') }}</p>
                            </div>
                        </a>

                        <a href="tel:{{ $phoneHref }}" dir="ltr" class="flex min-h-14 items-center gap-3 rounded-xl border border-border bg-white px-3.5 py-3 transition hover:border-primary/20 hover:bg-primary/5" aria-label="{{ __('contact.phone') }}: {{ $phoneRaw }}">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-accent/10 text-accent">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M6.75 3.75h3l1.5 3.75-1.9 1.9a14.2 14.2 0 0 0 5.25 5.25l1.9-1.9 3.75 1.5v3A1.5 1.5 0 0 1 18.75 20C10.6 20 4 13.4 4 5.25a1.5 1.5 0 0 1 2.75-1.5Z"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/55">{{ __('contact.phone') }}</p>
                                <p class="truncate text-sm font-semibold text-charcoal">{{ $phoneRaw }}</p>
                            </div>
                        </a>

                        <div class="flex min-h-14 items-center gap-3 rounded-xl border border-border bg-white px-3.5 py-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M12 20s6-5.8 6-10a6 6 0 0 0-12 0c0 4.2 6 10 6 10Z"/>
                                    <circle cx="12" cy="10" r="2.3" stroke-width="1.9"></circle>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/55">{{ __('contact.address') }}</p>
                                <p class="text-sm font-semibold leading-6 text-charcoal">{{ $address }}</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

