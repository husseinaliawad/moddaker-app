@php
    $appLocale = app()->getLocale();
    $locale = str_replace('_', '-', $appLocale);
    $direction = $textDirection ?? (in_array($appLocale, config('app.rtl_locales', ['ar', 'ur']), true) ? 'rtl' : 'ltr');

    $defaultTitle = $title ?? __('app.site_name');
    $defaultDescription = __('app.platform_tagline');
    $defaultImage = asset('images/moddaker-logo.svg');

    $metaTitle = trim($__env->yieldContent('meta_title')) ?: $defaultTitle;
    $metaDescription = trim($__env->yieldContent('meta_description')) ?: $defaultDescription;
    $metaKeywords = trim($__env->yieldContent('meta_keywords'));
    $metaRobots = trim($__env->yieldContent('meta_robots')) ?: 'index, follow, max-image-preview:large';

    $canonicalUrl = trim($__env->yieldContent('canonical_url')) ?: url()->current();
    $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    $ogTitle = trim($__env->yieldContent('og_title')) ?: $metaTitle;
    $ogDescription = trim($__env->yieldContent('og_description')) ?: $metaDescription;
    $ogImage = trim($__env->yieldContent('og_image')) ?: $defaultImage;
    $ogImageAlt = trim($__env->yieldContent('og_image_alt')) ?: $metaTitle;

    $twitterCard = trim($__env->yieldContent('twitter_card')) ?: 'summary_large_image';
    $twitterTitle = trim($__env->yieldContent('twitter_title')) ?: $ogTitle;
    $twitterDescription = trim($__env->yieldContent('twitter_description')) ?: $ogDescription;
    $twitterImage = trim($__env->yieldContent('twitter_image')) ?: $ogImage;
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription }}">
    @if ($metaKeywords !== '')
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <meta name="robots" content="{{ $metaRobots }}">

    <title>{{ $metaTitle }}</title>
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/moddaker-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/moddaker-logo.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/moddaker-logo.svg') }}">

    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:locale" content="{{ $locale }}">
    <meta property="og:site_name" content="{{ __('app.site_name') }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $ogImageAlt }}">

    <meta name="twitter:card" content="{{ $twitterCard }}">
    <meta name="twitter:title" content="{{ $twitterTitle }}">
    <meta name="twitter:description" content="{{ $twitterDescription }}">
    <meta name="twitter:image" content="{{ $twitterImage }}">

    @stack('structured-data')
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream text-charcoal">
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:start-3 focus:top-3 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-primary"
    >
        {{ in_array(app()->getLocale(), config('app.rtl_locales', ['ar', 'ur']), true) ? 'تخطي إلى المحتوى الرئيسي' : 'Skip to main content' }}
    </a>

    @include('frontend.partials.header')

    <main id="main-content" class="pt-20 lg:pt-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-flash-messages />
        </div>

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @stack('scripts')
</body>
</html>
