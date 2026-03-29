<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $textDirection ?? (in_array(app()->getLocale(), config('app.rtl_locales', ['ar', 'ur']), true) ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('student.dashboard') }} | {{ __('app.site_name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/moddaker-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/moddaker-logo.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/moddaker-logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="border-b border-border bg-white p-5 lg:border-b-0 lg:border-e">
            <a href="{{ route('home') }}" class="font-display text-3xl font-bold text-primary">مُدّكر</a>
            <p class="mt-1 text-xs text-charcoal/60">{{ __('student.portal') }}</p>

            <nav class="mt-8 space-y-2">
                <a href="{{ route('student.dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('student.dashboard') ? 'bg-primary text-white' : 'text-charcoal/80 hover:bg-cream' }}">
                    {{ __('student.dashboard') }}
                </a>
                <a href="{{ route('student.courses') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('student.courses') ? 'bg-primary text-white' : 'text-charcoal/80 hover:bg-cream' }}">
                    {{ __('student.my_courses') }}
                </a>
                <a href="{{ route('student.progress') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('student.progress') ? 'bg-primary text-white' : 'text-charcoal/80 hover:bg-cream' }}">
                    {{ __('student.progress') }}
                </a>
                <a href="{{ route('student.certificates') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('student.certificates') ? 'bg-primary text-white' : 'text-charcoal/80 hover:bg-cream' }}">
                    {{ __('student.certificates') }}
                </a>
                <a href="{{ route('student.profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold {{ request()->routeIs('student.profile.*') ? 'bg-primary text-white' : 'text-charcoal/80 hover:bg-cream' }}">
                    {{ __('student.profile') }}
                </a>
            </nav>
        </aside>

        <div>
            <header class="flex items-center justify-between border-b border-border bg-white px-4 py-3 sm:px-6">
                <h1 class="text-lg font-bold text-charcoal">@yield('page-title')</h1>
                <div class="flex items-center gap-2">
                    <x-language-switcher />
                    <a href="{{ route('home') }}" class="rounded-lg border border-border px-3 py-1.5 text-sm">{{ __('nav.home') }}</a>
                </div>
            </header>

            <main class="p-4 sm:p-6">
                <x-flash-messages />
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
