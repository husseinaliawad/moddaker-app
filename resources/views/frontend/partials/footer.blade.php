@php
    $socialLinks = collect($siteSocialLinks ?? [])->filter(fn ($link) => filled(data_get($link, 'url')));
@endphp

<footer class="relative overflow-hidden bg-charcoal text-white">
    <div class="pointer-events-none absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="footerPattern" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                    <circle cx="14" cy="14" r="1" fill="white" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#footerPattern)" />
        </svg>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ app()->getLocale() === 'ar' ? 'العودة إلى الصفحة الرئيسية' : 'Go to homepage' }}">
                    <span class="flex h-11 w-11 items-center justify-center">
                        <img src="{{ asset('images/moddaker-logo.svg') }}" alt="{{ __('app.site_name') }}" class="h-full w-full" width="44" height="44" loading="lazy" decoding="async">
                    </span>
                    <h3 class="font-display text-3xl font-bold text-white">{{ __('app.site_name') }}</h3>
                </a>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-white/80">
                    {{ __('app.platform_tagline') }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-5 text-sm text-white/90">
                    <a href="mailto:{{ data_get($siteContact, 'email', 'info@moddaker.com') }}" class="transition hover:text-accent">
                        {{ data_get($siteContact, 'email', 'info@moddaker.com') }}
                    </a>
                    <a href="tel:{{ preg_replace('/\s+/', '', data_get($siteContact, 'phone', '+966500000000')) }}" dir="ltr" class="transition hover:text-accent">
                        {{ data_get($siteContact, 'phone', '+966500000000') }}
                    </a>
                </div>
            </div>

            <div class="lg:col-span-3">
                <h4 class="text-base font-bold text-white">{{ __('nav.quick_links') }}</h4>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">{{ __('nav.home') }}</a></li>
                    <li><a href="{{ route('courses.index') }}" class="transition hover:text-white">{{ __('nav.courses') }}</a></li>
                    <li><a href="{{ route('about') }}" class="transition hover:text-white">{{ __('nav.about') }}</a></li>
                    <li><a href="{{ route('contact.create') }}" class="transition hover:text-white">{{ __('nav.contact') }}</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h4 class="text-base font-bold text-white">{{ __('footer.resources') }}</h4>
                <ul class="mt-4 space-y-2.5 text-sm text-white/75">
                    <li><a href="{{ route('faq') }}" class="transition hover:text-white">{{ __('nav.faq') }}</a></li>
                    <li><a href="#" class="transition hover:text-white">{{ __('app.privacy') }}</a></li>
                    <li><a href="#" class="transition hover:text-white">{{ __('app.terms') }}</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h4 class="text-base font-bold text-white">{{ __('footer.follow_us') }}</h4>

                <div class="mt-4 flex items-center gap-3">
                    @forelse ($socialLinks as $link)
                        @php($platform = mb_strtolower((string) data_get($link, 'platform', '')))
                        <a
                            href="{{ data_get($link, 'url', '#') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="{{ data_get($link, 'platform', 'Social') }}"
                            aria-label="{{ data_get($link, 'platform', 'Social') }}"
                            class="group inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 bg-white/5 text-white/80 transition duration-200 hover:-translate-y-0.5 hover:border-accent/70 hover:bg-accent hover:text-white"
                        >
                            @if ($platform === 'x' || $platform === 'twitter' || $platform === 'x-twitter')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M18.9 2h3.68l-8.05 9.2L24 22h-7.4l-5.8-6.8L4.86 22H1.18l8.61-9.85L0 2h7.6l5.24 6.16L18.9 2zM17.6 19.8h2.05L6.48 4.1H4.3L17.6 19.8z"/>
                                </svg>
                            @elseif ($platform === 'youtube')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12c0 2 .2 4 .5 5.8a3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1c.3-1.9.5-3.8.5-5.8s-.2-3.9-.5-5.8zM9.6 15.6V8.4L16 12l-6.4 3.6z"/>
                                </svg>
                            @elseif ($platform === 'telegram')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.6 0 12 0zm5.8 8.2-2 9.4c-.1.7-.5.9-1 .6l-3-2.2-1.5 1.5c-.2.2-.3.3-.6.3l.2-3.1 5.7-5.1c.2-.2-.1-.3-.4-.1l-7 4.4-3-.9c-.7-.2-.7-.7.1-1L17 7.4c.6-.2 1.1.1.8.8z"/>
                                </svg>
                            @else
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.6 9h16.8M3.6 15h16.8M12 3c2.5 2.4 3.8 5.4 3.8 9s-1.3 6.6-3.8 9m0-18c-2.5 2.4-3.8 5.4-3.8 9s1.3 6.6 3.8 9"/>
                                </svg>
                            @endif
                            <span class="sr-only">{{ data_get($link, 'platform', 'Social') }}</span>
                        </a>
                    @empty
                        <span class="text-sm text-white/60">{{ __('footer.no_social_links') }}</span>
                    @endforelse
                </div>

                <p class="mt-4 text-xs leading-relaxed text-white/60">
                    {{ __('footer.social_hint') }}
                </p>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-2 border-t border-white/15 pt-6 text-sm text-white/70 sm:flex-row sm:items-center sm:justify-between">
            <p>{{ __('app.copyright', ['year' => now()->year]) }}</p>
            <p>{{ __('footer.made_for_quran') }}</p>
        </div>
    </div>
</footer>
