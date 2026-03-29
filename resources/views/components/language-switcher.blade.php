@props([
    'buttonClass' => '',
    'menuClass' => '',
    'theme' => 'light',
])

@php
    $currentLocale = app()->getLocale();
    $locales = $supportedLocales ?? config('app.supported_locales', ['ar', 'en']);
    $labels = $localeLabels ?? config('app.locale_labels', []);
    $toggleLabel = 'Language selector';
    $isDark = $theme === 'dark';

    $buttonBaseClass = $isDark
        ? 'inline-flex h-10 items-center gap-2 rounded-lg border border-white/15 bg-white/[0.06] px-3 text-xs font-semibold uppercase tracking-[0.08em] text-white shadow-[0_12px_22px_-16px_rgba(0,0,0,0.6)] transition duration-150 hover:bg-white/[0.12] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/30'
        : 'inline-flex h-10 items-center gap-2 rounded-lg border border-border/70 bg-white/95 px-3 text-xs font-semibold uppercase tracking-[0.08em] text-charcoal/80 shadow-sm transition duration-150 hover:bg-cream hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/35';

    $menuBaseClass = $isDark
        ? 'border-white/10 bg-[#151520]/95 shadow-[0_20px_44px_-18px_rgba(0,0,0,0.55)]'
        : 'border-border/70 bg-white/95 shadow-[0_18px_34px_-18px_rgba(28,36,48,0.35)]';
@endphp

<div {{ $attributes->merge(['class' => 'relative']) }} x-data="{ open: false }" @keydown.escape.window="open = false">
    <button
        type="button"
        @click="open = !open"
        :aria-expanded="open.toString()"
        aria-haspopup="menu"
        aria-label="{{ $toggleLabel }}"
        class="{{ $buttonBaseClass }} {{ $buttonClass }}"
    >
        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a9 9 0 1 0 9 9 9 9 0 0 0-9-9Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3c2.7 2.45 4.2 5.67 4.2 9s-1.5 6.55-4.2 9m0-18c-2.7 2.45-4.2 5.67-4.2 9s1.5 6.55 4.2 9"/>
        </svg>

        <span>{{ strtoupper($currentLocale) }}</span>

        <svg
            class="h-3.5 w-3.5 shrink-0 transition-transform duration-150"
            :class="{ 'rotate-180': open }"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
        >
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.1 1.02l-4.25 4.5a.75.75 0 0 1-1.1 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
        </svg>
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-1 scale-95"
        @click.outside="open = false"
        class="absolute end-0 top-[calc(100%+0.45rem)] z-[70] w-60 overflow-hidden rounded-lg border backdrop-blur-sm {{ $menuBaseClass }} {{ $menuClass }}"
        role="menu"
        aria-label="{{ $toggleLabel }}"
    >
        <div class="max-h-72 overflow-y-auto p-1">
            @foreach ($locales as $localeCode)
                @php
                    $isCurrent = $localeCode === $currentLocale;
                    $localeLabel = data_get($labels, $localeCode, strtoupper($localeCode));
                    $itemClass = $isDark
                        ? ($isCurrent ? 'bg-white text-charcoal' : 'text-white/80 hover:bg-white/[0.08] hover:text-white')
                        : ($isCurrent ? 'bg-primary/10 text-primary' : 'text-charcoal/80 hover:bg-cream hover:text-charcoal');
                    $chipClass = $isDark
                        ? ($isCurrent ? 'bg-charcoal/10 text-charcoal' : 'bg-white/[0.12] text-white')
                        : ($isCurrent ? 'bg-primary/20 text-primary' : 'bg-primary/10 text-primary');
                @endphp

                <a
                    href="{{ route('locale.switch', $localeCode) }}"
                    class="group flex items-center justify-between gap-3 rounded-md px-3 py-2.5 text-sm transition duration-150 {{ $itemClass }}"
                    role="menuitem"
                    @click="open = false"
                >
                    <span class="flex min-w-0 items-center gap-2.5">
                        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-md text-[10px] font-bold uppercase tracking-[0.08em] {{ $chipClass }}">
                            {{ strtoupper($localeCode) }}
                        </span>
                        <span class="truncate">{{ $localeLabel }}</span>
                    </span>

                    @if ($isCurrent)
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.002 7.061a1 1 0 0 1-1.426-.01L4.29 9.653a1 1 0 1 1 1.42-1.407l2.282 2.302 6.3-6.35a1 1 0 0 1 1.412-.008Z" clip-rule="evenodd"/>
                        </svg>
                    @else
                        <span class="text-[10px] font-semibold uppercase tracking-[0.14em] {{ $isDark ? 'text-white/35 group-hover:text-white/60' : 'text-charcoal/35 group-hover:text-charcoal/55' }}">
                            {{ strtoupper($localeCode) }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
