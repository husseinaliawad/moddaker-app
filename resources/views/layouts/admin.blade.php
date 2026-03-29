<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $textDirection ?? (in_array(app()->getLocale(), config('app.rtl_locales', ['ar', 'ur']), true) ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('admin.dashboard') }} | {{ __('app.site_name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/moddaker-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/moddaker-logo.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/moddaker-logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="admin-shell min-h-screen"
    x-data="{ mobileNavOpen: false }"
    x-on:keydown.escape.window="mobileNavOpen = false"
    x-on:resize.window="if (window.innerWidth >= 1024) mobileNavOpen = false"
    :class="{ 'overflow-hidden': mobileNavOpen }"
>
    @php
        $adminUser = auth()->user();
        $adminInitials = collect(explode(' ', (string) $adminUser?->name))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_substr($part, 0, 1))
            ->join('');

        $navItems = [
            ['route' => 'admin.dashboard', 'label' => __('admin.dashboard'), 'icon' => 'dashboard'],
            ['route' => 'admin.users.index', 'label' => __('admin.users'), 'icon' => 'users'],
            ['route' => 'admin.roles.index', 'label' => __('admin.roles_permissions'), 'icon' => 'shield'],
            ['route' => 'admin.categories.index', 'label' => __('admin.categories'), 'icon' => 'categories'],
            ['route' => 'admin.courses.index', 'label' => __('admin.courses'), 'icon' => 'courses'],
            ['route' => 'admin.lessons.index', 'label' => __('admin.lessons'), 'icon' => 'lessons'],
            ['route' => 'admin.instructors.index', 'label' => __('admin.instructors'), 'icon' => 'instructors'],
            ['route' => 'admin.enrollments.index', 'label' => __('admin.enrollments'), 'icon' => 'enrollments'],
            ['route' => 'admin.certificates.index', 'label' => __('admin.certificates'), 'icon' => 'certificates'],
            ['route' => 'admin.quizzes.index', 'label' => __('admin.quizzes'), 'icon' => 'quizzes'],
            ['route' => 'admin.pages.index', 'label' => __('admin.pages'), 'icon' => 'pages'],
            ['route' => 'admin.settings.index', 'label' => __('admin.settings'), 'icon' => 'settings'],
            [
                'route' => 'admin.contact-messages.index',
                'label' => __('admin.messages'),
                'icon' => 'messages',
                'badge' => $adminUnreadMessages ?? null,
            ],
        ];

        $navItemsByRoute = [];
        foreach ($navItems as $item) {
            $navItemsByRoute[$item['route']] = $item;
        }

        $sidebarSections = [
            ['title' => 'General', 'routes' => ['admin.dashboard']],
            ['title' => 'Management', 'routes' => ['admin.users.index', 'admin.instructors.index', 'admin.categories.index', 'admin.courses.index', 'admin.lessons.index']],
            ['title' => 'Content', 'routes' => ['admin.enrollments.index', 'admin.certificates.index', 'admin.quizzes.index', 'admin.pages.index']],
            ['title' => 'System', 'routes' => ['admin.settings.index', 'admin.roles.index']],
            ['title' => 'Communication', 'routes' => ['admin.contact-messages.index']],
        ];
    @endphp

    <div class="min-h-screen lg:grid lg:grid-cols-[320px_minmax(0,1fr)]">
        <div
            x-cloak
            x-show="mobileNavOpen"
            x-transition.opacity.duration.200ms
            class="fixed inset-0 z-40 bg-charcoal/55 backdrop-blur-[2px] lg:hidden"
            aria-hidden="true"
            @click.self="mobileNavOpen = false"
        ></div>

        <aside
            class="fixed inset-y-0 right-0 z-50 flex w-[86vw] min-w-[280px] max-w-[350px] flex-col overflow-hidden border-s border-white/10 bg-[linear-gradient(180deg,rgba(18,18,24,0.96)_0%,rgba(13,13,18,0.94)_100%)] text-white shadow-[0_26px_70px_rgba(0,0,0,0.45)] backdrop-blur-xl transition-transform duration-300 ease-out will-change-transform lg:static lg:z-auto lg:w-auto lg:min-w-0 lg:max-w-none lg:translate-x-0 lg:border-s lg:border-white/10 lg:shadow-none"
            :class="mobileNavOpen ? 'translate-x-0' : 'translate-x-full'"
            tabindex="-1"
            @click.stop
        >
            <div class="flex h-full min-h-0 flex-col">
                <div class="flex items-center justify-between border-b border-white/10 px-3.5 py-3">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex min-w-0 items-center gap-2" @click="mobileNavOpen = false">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-white/15 bg-white/[0.06] text-white">
                            <x-admin.icon name="dashboard" class="h-4 w-4" />
                        </span>
                        <span class="truncate text-sm font-semibold text-white/95">{{ __('app.site_name') }}</span>
                    </a>

                    <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/15 bg-white/[0.06] text-white/80 transition hover:bg-white/[0.12] hover:text-white lg:hidden"
                        @click.stop="mobileNavOpen = false"
                        aria-label="{{ __('admin.close_navigation') }}"
                    >
                        <x-admin.icon name="close" class="h-4 w-4" />
                    </button>
                </div>

                <div class="border-b border-white/10 px-3.5 py-3">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5" @click="mobileNavOpen = false">
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-white to-white/70 text-xs font-bold uppercase text-[#3a2c42]">
                            {{ $adminInitials !== '' ? $adminInitials : 'AD' }}
                        </span>
                        <span class="truncate text-sm font-medium text-white/90">{{ $adminUser?->name }}</span>
                    </a>
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto px-2.5 py-3">
                    @foreach ($sidebarSections as $section)
                        <section class="{{ $loop->first ? '' : 'mt-4' }}">
                            <p class="mb-1.5 px-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-white/40">
                                {{ $section['title'] }}
                            </p>

                            <nav class="space-y-1">
                                @foreach ($section['routes'] as $routeName)
                                    @php
                                        $item = $navItemsByRoute[$routeName] ?? null;
                                    @endphp

                                    @continue(! $item)

                                    @php
                                        $isActive = request()->routeIs(str_replace('.index', '.*', $item['route'])) || request()->routeIs($item['route']);
                                    @endphp

                                    <a
                                        href="{{ route($item['route']) }}"
                                        class="group relative flex min-h-11 items-center gap-2.5 rounded-xl border px-2.5 py-2 text-sm font-medium transition-all duration-200 {{ $isActive ? 'border-primary/45 bg-primary/20 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.05)]' : 'border-transparent text-white/75 hover:border-white/10 hover:bg-white/[0.05] hover:text-white' }}"
                                        @click="mobileNavOpen = false"
                                    >
                                        <span class="absolute inset-y-2 start-0 w-0.5 rounded-full bg-accent {{ $isActive ? 'opacity-100' : 'opacity-0 group-hover:opacity-60' }}"></span>

                                        <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/[0.04] text-white/85 transition {{ $isActive ? 'border-primary/30 bg-primary/25 text-white' : 'group-hover:bg-white/[0.1]' }}">
                                            <x-admin.icon :name="$item['icon']" class="h-[16px] w-[16px]" />
                                        </span>

                                        <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>

                                        @if (! empty($item['badge']))
                                            <span class="inline-flex min-w-[1.5rem] items-center justify-center rounded-full bg-accent px-2 py-1 text-[11px] font-bold text-white">
                                                {{ min($item['badge'], 99) }}
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </nav>
                        </section>
                    @endforeach
                </div>

                <div class="border-t border-white/10 px-3 py-3">
                    <x-language-switcher
                        theme="dark"
                        class="w-full"
                        button-class="w-full justify-between"
                        menu-class="w-full"
                    />

                    <div class="mt-2 grid gap-1.5">
                        <a
                            href="{{ route('home') }}"
                            class="inline-flex min-h-10 items-center justify-center rounded-lg border border-white/10 bg-white/[0.04] px-3 text-sm font-medium text-white/90 transition hover:bg-white/[0.1]"
                            @click="mobileNavOpen = false"
                        >
                            {{ __('admin.open_site') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}" @submit="mobileNavOpen = false">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex min-h-10 w-full items-center justify-center rounded-lg border border-rose-300/25 bg-rose-500/10 px-3 text-sm font-medium text-rose-200 transition hover:bg-rose-500/20"
                            >
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="min-w-0">
            <header class="admin-topbar sticky top-0 z-30 px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between gap-3 lg:hidden">
                    <button
                        type="button"
                        class="admin-icon-btn admin-icon-btn-light"
                        @click.stop="mobileNavOpen = true"
                        aria-label="{{ __('admin.open_navigation') }}"
                    >
                        <x-admin.icon name="menu" class="h-5 w-5" />
                    </button>

                    <div class="min-w-0 flex-1 text-center">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-charcoal/40">
                            {{ __('admin.live_overview') }}
                        </p>
                        <h1 class="mt-1 truncate text-lg font-bold tracking-tight text-charcoal">
                            @yield('page-title')
                        </h1>
                    </div>

                    <div
                        class="relative"
                        x-data="{ notificationsOpen: false }"
                        @keydown.escape.window="notificationsOpen = false"
                    >
                        <button
                            type="button"
                            class="admin-icon-btn admin-icon-btn-light relative"
                            @click.stop="notificationsOpen = !notificationsOpen"
                            :aria-expanded="notificationsOpen.toString()"
                            aria-controls="admin-notifications-menu-mobile"
                            aria-label="{{ __('admin.notifications') }}"
                        >
                            <x-admin.icon name="bell" class="h-5 w-5" />
                            @if (($adminUnreadMessages ?? 0) > 0)
                                <span class="admin-notification-dot">
                                    {{ min($adminUnreadMessages, 99) }}
                                </span>
                            @endif
                        </button>

                        <div
                            id="admin-notifications-menu-mobile"
                            x-cloak
                            x-show="notificationsOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            @click.outside="notificationsOpen = false"
                            @click.stop
                            class="absolute top-[calc(100%+0.6rem)] end-0 z-40 w-[min(88vw,22rem)] rounded-2xl border border-border/80 bg-white/95 p-3 shadow-[0_18px_40px_rgba(0,0,0,0.14)] backdrop-blur-xl"
                            role="menu"
                            aria-label="{{ __('admin.notifications') }}"
                        >
                            <div class="mb-3 flex items-center justify-between gap-3 border-b border-border/70 pb-2">
                                <p class="text-sm font-semibold text-charcoal">{{ __('admin.notifications') }}</p>
                                <button
                                    type="button"
                                    class="admin-icon-btn admin-icon-btn-light h-9 w-9 rounded-xl"
                                    @click.stop="notificationsOpen = false"
                                    aria-label="{{ __('admin.close_navigation') }}"
                                >
                                    <x-admin.icon name="close" class="h-4 w-4" />
                                </button>
                            </div>

                            <div class="space-y-2">
                                <a
                                    href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}"
                                    class="flex items-center justify-between rounded-xl border border-border/70 px-3 py-2.5 text-sm text-charcoal transition hover:bg-cream"
                                    @click="notificationsOpen = false"
                                    role="menuitem"
                                >
                                    <span>{{ __('admin.unread_messages') }}</span>
                                    <span class="rounded-full bg-primary/10 px-2 py-1 text-xs font-semibold text-primary">
                                        {{ min($adminUnreadMessages ?? 0, 99) }}
                                    </span>
                                </a>

                                <a
                                    href="{{ route('admin.contact-messages.index') }}"
                                    class="flex items-center justify-between rounded-xl border border-border/70 px-3 py-2.5 text-sm text-charcoal transition hover:bg-cream"
                                    @click="notificationsOpen = false"
                                    role="menuitem"
                                >
                                    <span>{{ __('admin.view_messages') }}</span>
                                    <x-admin.icon name="messages" class="h-4 w-4 text-primary/80" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden items-center justify-between gap-6 lg:flex">
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-charcoal/45">
                            {{ __('admin.live_overview') }}
                        </p>

                        <div class="mt-1 flex flex-wrap items-center gap-3">
                            <h1 class="text-2xl font-bold tracking-tight text-charcoal">
                                @yield('page-title')
                            </h1>

                            @hasSection('page-subtitle')
                                <span class="h-1.5 w-1.5 rounded-full bg-charcoal/20"></span>
                                <p class="text-sm text-charcoal/60">@yield('page-subtitle')</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <form action="{{ route('admin.dashboard') }}" method="get" class="relative min-w-0 xl:w-80">
                            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4 text-charcoal/35">
                                <x-admin.icon name="search" class="h-5 w-5" />
                            </span>

                            <input
                                type="search"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="{{ __('admin.search_everything') }}"
                                class="admin-topbar-search"
                            >
                        </form>

                        <div
                            class="relative"
                            x-data="{ notificationsOpen: false }"
                            @keydown.escape.window="notificationsOpen = false"
                        >
                            <button
                                type="button"
                                class="admin-icon-btn admin-icon-btn-light relative"
                                @click.stop="notificationsOpen = !notificationsOpen"
                                :aria-expanded="notificationsOpen.toString()"
                                aria-controls="admin-notifications-menu-desktop"
                                aria-label="{{ __('admin.notifications') }}"
                            >
                                <x-admin.icon name="bell" class="h-5 w-5" />
                                @if (($adminUnreadMessages ?? 0) > 0)
                                    <span class="admin-notification-dot">
                                        {{ min($adminUnreadMessages, 99) }}
                                    </span>
                                @endif
                            </button>

                            <div
                                id="admin-notifications-menu-desktop"
                                x-cloak
                                x-show="notificationsOpen"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                @click.outside="notificationsOpen = false"
                                @click.stop
                                class="absolute top-[calc(100%+0.6rem)] end-0 z-40 w-80 rounded-2xl border border-border/80 bg-white/95 p-3 shadow-[0_18px_40px_rgba(0,0,0,0.14)] backdrop-blur-xl"
                                role="menu"
                                aria-label="{{ __('admin.notifications') }}"
                            >
                                <div class="mb-3 flex items-center justify-between gap-3 border-b border-border/70 pb-2">
                                    <p class="text-sm font-semibold text-charcoal">{{ __('admin.notifications') }}</p>
                                    <button
                                        type="button"
                                        class="admin-icon-btn admin-icon-btn-light h-9 w-9 rounded-xl"
                                        @click.stop="notificationsOpen = false"
                                        aria-label="{{ __('admin.close_navigation') }}"
                                    >
                                        <x-admin.icon name="close" class="h-4 w-4" />
                                    </button>
                                </div>

                                <div class="space-y-2">
                                    <a
                                        href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}"
                                        class="flex items-center justify-between rounded-xl border border-border/70 px-3 py-2.5 text-sm text-charcoal transition hover:bg-cream"
                                        @click="notificationsOpen = false"
                                        role="menuitem"
                                    >
                                        <span>{{ __('admin.unread_messages') }}</span>
                                        <span class="rounded-full bg-primary/10 px-2 py-1 text-xs font-semibold text-primary">
                                            {{ min($adminUnreadMessages ?? 0, 99) }}
                                        </span>
                                    </a>

                                    <a
                                        href="{{ route('admin.contact-messages.index') }}"
                                        class="flex items-center justify-between rounded-xl border border-border/70 px-3 py-2.5 text-sm text-charcoal transition hover:bg-cream"
                                        @click="notificationsOpen = false"
                                        role="menuitem"
                                    >
                                        <span>{{ __('admin.view_messages') }}</span>
                                        <x-admin.icon name="messages" class="h-4 w-4 text-primary/80" />
                                    </a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('home') }}" class="admin-soft-btn-light inline-flex items-center gap-2">
                            <x-admin.icon name="home" class="h-4 w-4 text-primary" />
                            {{ __('admin.open_site') }}
                        </a>

                        <x-language-switcher />

                        <a href="{{ route('profile.edit') }}" class="admin-user-trigger">
                            <div class="admin-user-trigger__avatar">
                                {{ $adminInitials !== '' ? $adminInitials : 'AD' }}
                            </div>

                            <div class="hidden min-w-0 xl:block">
                                <p class="truncate text-sm font-semibold text-charcoal">{{ $adminUser?->name }}</p>
                                <p class="truncate text-xs text-charcoal/50">{{ __('admin.administrator') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                <x-flash-messages />
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
