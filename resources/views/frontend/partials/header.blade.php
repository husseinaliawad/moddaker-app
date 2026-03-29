@php
    $navItems = [
        ['label' => __('nav.home'), 'route' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => __('nav.courses'), 'route' => route('courses.index'), 'active' => request()->routeIs('courses.*', 'lessons.*')],
        ['label' => __('nav.about'), 'route' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => __('nav.faq'), 'route' => route('faq'), 'active' => request()->routeIs('faq')],
        ['label' => __('nav.contact'), 'route' => route('contact.create'), 'active' => request()->routeIs('contact.*')],
    ];
@endphp

<header
    x-data="{ mobileMenuOpen: false }"
    @keydown.escape.window="mobileMenuOpen = false"
    class="fixed inset-x-0 top-0 z-50 border-b border-border/70 bg-cream/95 backdrop-blur-xl"
>
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-primary/20 via-accent/40 to-primary/20"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between lg:h-20">
            <a href="{{ route('home') }}" class="group inline-flex min-w-0 items-center gap-2.5" aria-label="{{ app()->getLocale() === 'ar' ? 'العودة إلى الصفحة الرئيسية' : 'Go to homepage' }}">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-border/80 bg-white shadow-sm transition group-hover:-translate-y-0.5 group-hover:shadow-md lg:h-11 lg:w-11">
                    <img src="{{ asset('images/moddaker-logo.svg') }}" alt="{{ __('app.site_name') }}" class="h-full w-full" width="44" height="44" loading="eager" decoding="async">
                </span>
                <span class="font-display truncate text-xl font-bold tracking-tight text-primary lg:text-3xl">{{ __('app.site_name') }}</span>
            </a>

            <nav class="hidden items-center gap-6 lg:flex" aria-label="{{ app()->getLocale() === 'ar' ? 'التنقل الرئيسي' : 'Primary navigation' }}">
                @foreach ($navItems as $item)
                    <a
                        href="{{ $item['route'] }}"
                        class="relative pb-1 text-sm font-semibold transition after:absolute after:-bottom-2 after:start-0 after:h-0.5 after:rounded-full after:bg-accent after:transition-all {{ $item['active'] ? 'text-primary after:w-full' : 'text-charcoal/80 hover:text-primary after:w-0 hover:after:w-full' }}"
                    >
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2 lg:gap-3">
                <x-language-switcher class="hidden sm:block" />

                @auth
                    <a
                        href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('student.dashboard') }}"
                        class="hidden items-center rounded-full bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-[0_14px_26px_-16px_rgba(10,77,64,0.9)] transition duration-300 hover:-translate-y-0.5 hover:bg-primaryDark sm:inline-flex"
                    >
                        {{ __('nav.dashboard') }}
                    </a>
                    <form action="{{ route('logout') }}" method="post" class="hidden sm:block">
                        @csrf
                        <button class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold text-charcoal/80 ring-1 ring-border/80 transition hover:bg-white hover:text-primary">
                            {{ __('auth.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                    class="hidden items-center rounded-full px-4 py-2 text-sm font-semibold text-charcoal/80 ring-1 ring-border/80 transition hover:bg-white hover:text-primary sm:inline-flex">
                        {{ __('auth.login') }}
                    </a>
                    <a href="{{ route('register') }}"
                    class="hidden items-center rounded-full bg-primary px-6 py-2.5 text-sm font-bold text-white shadow-[0_14px_26px_-16px_rgba(10,77,64,0.9)] transition duration-300 hover:-translate-y-0.5 hover:bg-primaryDark sm:inline-flex">
                        {{ __('auth.register') }}
                    </a>
                @endauth

                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-border bg-white text-charcoal shadow-sm transition hover:bg-cream lg:hidden"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    :aria-expanded="mobileMenuOpen.toString()"
                    aria-controls="mobile-nav-panel"
                    aria-label="{{ app()->getLocale() === 'ar' ? 'القائمة الرئيسية للجوال' : 'Mobile navigation menu' }}"
                >
                    <svg x-show="!mobileMenuOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 6 12 12M18 6 6 18"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div
        id="mobile-nav-panel"
        x-cloak
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-180"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-120"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="border-t border-border bg-cream/95 px-4 pb-4 pt-3 shadow-[0_22px_40px_-28px_rgba(26,26,26,0.75)] lg:hidden"
        @click.outside="mobileMenuOpen = false"
    >
        <nav class="space-y-1.5">
            @foreach ($navItems as $item)
                <a
                    href="{{ $item['route'] }}"
                    class="flex min-h-11 items-center rounded-xl px-3 text-sm font-semibold transition {{ $item['active'] ? 'bg-primary text-white shadow-sm' : 'text-charcoal/85 hover:bg-white' }}"
                    @click="mobileMenuOpen = false"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <x-language-switcher
            class="mt-3 w-full"
            button-class="w-full justify-between"
            menu-class="w-full"
        />

        @auth
            <div class="mt-3 grid grid-cols-2 gap-2">
                <a
                    href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('student.dashboard') }}"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-primary px-4 text-sm font-bold text-white"
                    @click="mobileMenuOpen = false"
                >
                    {{ __('nav.dashboard') }}
                </a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-border bg-white px-4 text-sm font-semibold text-charcoal/85">
                        {{ __('auth.logout') }}
                    </button>
                </form>
            </div>
        @else
            <div class="mt-3 grid grid-cols-2 gap-2">
                <a href="{{ route('login') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-border bg-white px-4 text-sm font-semibold text-charcoal/85" @click="mobileMenuOpen = false">
                    {{ __('auth.login') }}
                </a>
                <a href="{{ route('register') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-primary px-4 text-sm font-bold text-white" @click="mobileMenuOpen = false">
                    {{ __('auth.register') }}
                </a>
            </div>
        @endauth
    </div>
</header>

