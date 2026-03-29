@extends('layouts.admin')

@section('page-title', __('admin.dashboard'))
@section('page-subtitle', __('admin.dashboard_subtitle'))

@section('content')
    @php
        $featuredStat = $stats['enrollments'];

        $secondaryCards = [
            [
                'stat' => $stats['users'],
                'label' => __('admin.total_users'),
                'icon' => 'users',
                'support' => __('admin.new_this_week_count', ['count' => $stats['users']['period_count']]),
                'accent' => 'from-[#6b5b95] via-[#8b74c4] to-[#c9b6e4]',
                'iconBg' => 'bg-[#f1eafe]',
                'iconColor' => 'text-[#5e44a7]',
            ],
            [
                'stat' => $stats['courses'],
                'label' => __('admin.total_courses'),
                'icon' => 'courses',
                'support' => __('admin.published_count', ['count' => $stats['courses']['secondary']]),
                'accent' => 'from-[#dc7f52] via-[#f0a06f] to-[#f6d0a9]',
                'iconBg' => 'bg-[#fff1e6]',
                'iconColor' => 'text-[#cf6a37]',
            ],
            [
                'stat' => $stats['messages'],
                'label' => __('admin.unread_messages'),
                'icon' => 'messages',
                'support' => __('admin.new_messages_week_count', ['count' => $stats['messages']['period_count']]),
                'accent' => 'from-[#2c6d7d] via-[#3e91a6] to-[#b3dfe8]',
                'iconBg' => 'bg-[#e8f6fa]',
                'iconColor' => 'text-[#246477]',
            ],
        ];

        $quickActions = [
            ['label' => __('admin.add_course'), 'route' => route('admin.courses.create'), 'icon' => 'courses'],
            ['label' => __('admin.add_lesson'), 'route' => route('admin.lessons.create'), 'icon' => 'lessons'],
            ['label' => __('admin.add_user'), 'route' => route('admin.users.create'), 'icon' => 'users'],
            ['label' => __('admin.view_messages'), 'route' => route('admin.contact-messages.index', ['status' => 'unread']), 'icon' => 'messages'],
        ];

        $performanceItems = [
            ['label' => __('admin.publishing_rate'), 'value' => $performance['publishing_rate'], 'hint' => __('admin.draft_courses_count', ['count' => $performance['draft_courses']])],
            ['label' => __('admin.completion_rate'), 'value' => $performance['completion_rate'], 'hint' => __('admin.completed_enrollments_count', ['count' => $performance['completed_enrollments']])],
            ['label' => __('admin.response_rate'), 'value' => $performance['response_rate'], 'hint' => __('admin.unread_messages_rate', ['count' => $performance['unread_rate']])],
            ['label' => __('admin.learning_progress'), 'value' => $performance['average_progress'], 'hint' => __('admin.active_enrollments_count', ['count' => $performance['active_enrollments']])],
        ];

        $topCourseMax = max(1, (int) ($topCourses->max('enrollments_count') ?: 0));
    @endphp

    <div class="space-y-4 md:hidden">
        <section class="rounded-3xl border border-border/70 bg-white/85 p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-charcoal/45">{{ __('admin.live_overview') }}</p>
                    <h2 class="mt-1 truncate text-xl font-bold tracking-tight text-charcoal">{{ __('admin.dashboard') }}</h2>
                    <p class="mt-1 truncate text-sm text-charcoal/60">{{ auth()->user()?->name }}</p>
                </div>

                <a
                    href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}"
                    class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl border border-primary/20 bg-primary/10 text-primary transition hover:bg-primary/15"
                    aria-label="{{ __('admin.view_messages') }}"
                >
                    <x-admin.icon name="messages" class="h-5 w-5" />
                </a>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-2">
                <div class="rounded-2xl border border-border/70 bg-[#fbf8f3] p-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-charcoal/45">{{ __('admin.unread_messages') }}</p>
                    <p class="mt-1 text-xl font-bold text-charcoal">{{ number_format($stats['messages']['value']) }}</p>
                </div>
                <div class="rounded-2xl border border-border/70 bg-[#fbf8f3] p-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-charcoal/45">{{ __('admin.total_users') }}</p>
                    <p class="mt-1 text-xl font-bold text-charcoal">{{ number_format($stats['users']['value']) }}</p>
                </div>
                <div class="rounded-2xl border border-border/70 bg-[#fbf8f3] p-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-charcoal/45">{{ __('admin.total_enrollments') }}</p>
                    <p class="mt-1 text-xl font-bold text-charcoal">{{ number_format($stats['enrollments']['value']) }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-border/70 bg-white/85 p-4 shadow-sm">
            <div class="mb-3 flex items-center justify-between gap-2">
                <h3 class="text-base font-bold text-charcoal">{{ __('admin.quick_actions') }}</h3>
                <span class="text-xs font-medium text-charcoal/50">{{ __('admin.run_the_day') }}</span>
            </div>

            <div class="grid grid-cols-2 gap-2">
                @foreach ($quickActions as $action)
                    <a
                        href="{{ $action['route'] }}"
                        class="group inline-flex min-h-16 items-center gap-2 rounded-2xl border border-border/70 bg-[#fbf8f3] px-3 py-3 text-charcoal transition hover:-translate-y-0.5 hover:border-primary/20 hover:bg-white"
                    >
                        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary transition group-hover:bg-primary/15">
                            <x-admin.icon :name="$action['icon']" class="h-4 w-4" />
                        </span>
                        <span class="text-sm font-semibold leading-snug">{{ $action['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section>
            <div class="mb-2 flex items-center justify-between gap-2 px-1">
                <h3 class="text-base font-bold text-charcoal">{{ __('admin.performance_snapshot') }}</h3>
                <span class="rounded-full bg-primary/10 px-2.5 py-1 text-[11px] font-semibold text-primary">{{ __('admin.last_7_days') }}</span>
            </div>

            <div class="-mx-4 overflow-x-auto px-4">
                <div class="flex w-max snap-x snap-mandatory gap-2 pb-1">
                    <article class="w-44 snap-start rounded-2xl border border-border/70 bg-white/85 p-3 shadow-sm">
                        <p class="text-xs font-medium text-charcoal/55">{{ __('admin.total_enrollments') }}</p>
                        <p class="mt-2 text-2xl font-black tracking-tight text-charcoal">{{ number_format($featuredStat['value']) }}</p>
                        <div class="mt-2 inline-flex items-center gap-1 rounded-full px-2 py-1 text-[11px] font-semibold {{ $featuredStat['direction'] === 'up' ? 'bg-emerald-50 text-emerald-700' : ($featuredStat['direction'] === 'down' ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-600') }}">
                            <x-admin.icon name="trend-{{ $featuredStat['direction'] }}" class="h-3.5 w-3.5" />
                            {{ ($featuredStat['percentage'] > 0 ? '+' : '') . $featuredStat['percentage'] }}%
                        </div>
                    </article>

                    @foreach ($secondaryCards as $card)
                        <article class="w-44 snap-start rounded-2xl border border-border/70 bg-white/85 p-3 shadow-sm">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-xs font-medium text-charcoal/55">{{ $card['label'] }}</p>
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $card['iconBg'] }} {{ $card['iconColor'] }}">
                                    <x-admin.icon :name="$card['icon']" class="h-4 w-4" />
                                </span>
                            </div>
                            <p class="mt-2 text-2xl font-black tracking-tight text-charcoal">{{ number_format($card['stat']['value']) }}</p>
                            <p class="mt-1 truncate text-[11px] text-charcoal/50">{{ $card['support'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <details class="group overflow-hidden rounded-2xl border border-border/70 bg-white/85 shadow-sm">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-2 px-4 py-3">
                <div>
                    <h3 class="text-base font-bold text-charcoal">{{ __('admin.weekly_activity') }}</h3>
                    <p class="text-xs text-charcoal/55">{{ __('admin.last_7_days') }}</p>
                </div>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary transition">
                    <x-admin.icon name="trend-down" class="h-4 w-4" />
                </span>
            </summary>

            <div class="space-y-2 px-4 pb-4">
                @foreach ($activity as $day)
                    <div class="rounded-xl border border-border/60 bg-[#fbf8f3] p-3">
                        <div class="mb-2 flex items-center justify-between text-xs font-semibold text-charcoal/65">
                            <span>{{ $day['label'] }}</span>
                            <span>{{ $day['full_label'] }}</span>
                        </div>
                        <div class="space-y-1.5">
                            @foreach ([
                                ['label' => __('admin.signups'), 'value' => $day['users'], 'color' => 'bg-[#775bd4]'],
                                ['label' => __('admin.enrollments'), 'value' => $day['enrollments'], 'color' => 'bg-[#e68857]'],
                                ['label' => __('admin.messages'), 'value' => $day['messages'], 'color' => 'bg-[#2e8398]'],
                            ] as $metric)
                                @php
                                    $metricWidth = max(6, (int) round(($metric['value'] / $chartMax) * 100));
                                @endphp
                                <div class="flex items-center gap-2 text-[11px] text-charcoal/60">
                                    <span class="w-16 shrink-0 truncate">{{ $metric['label'] }}</span>
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-black/10">
                                        <div class="h-full rounded-full {{ $metric['color'] }}" style="width: {{ $metricWidth }}%;"></div>
                                    </div>
                                    <span class="w-6 shrink-0 text-end font-semibold text-charcoal/80">{{ $metric['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </details>

        <section class="rounded-2xl border border-border/70 bg-white/85 p-4 shadow-sm">
            <div class="flex items-center justify-between gap-2">
                <h3 class="text-base font-bold text-charcoal">{{ __('admin.latest_messages') }}</h3>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-semibold text-primary">{{ __('admin.manage') }}</a>
            </div>

            <div class="mt-3 divide-y divide-border/70">
                @forelse ($recentMessages as $message)
                    <a href="{{ route('admin.contact-messages.show', $message) }}" class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                        <span class="mt-1.5 inline-flex h-2.5 w-2.5 shrink-0 rounded-full {{ $message->is_read ? 'bg-slate-300' : 'bg-emerald-500' }}"></span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-sm font-semibold text-charcoal">{{ $message->name }}</p>
                                <span class="shrink-0 text-[11px] text-charcoal/45">{{ $message->created_at->format('Y-m-d') }}</span>
                            </div>
                            <p class="mt-1 truncate text-sm text-charcoal/60">{{ $message->subject }}</p>
                            <p class="mt-1 truncate text-xs text-charcoal/45">{{ $message->email }}</p>
                        </div>
                    </a>
                @empty
                    <p class="py-3 text-sm text-charcoal/60">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-border/70 bg-white/85 p-4 shadow-sm">
            <div class="flex items-center justify-between gap-2">
                <h3 class="text-base font-bold text-charcoal">{{ __('admin.latest_enrollments') }}</h3>
                <a href="{{ route('admin.enrollments.index') }}" class="text-xs font-semibold text-primary">{{ __('admin.manage') }}</a>
            </div>

            <div class="mt-3 space-y-2">
                @forelse ($recentEnrollments as $enrollment)
                    @php
                        $statusClasses = match ($enrollment->status) {
                            'completed' => 'bg-emerald-50 text-emerald-700',
                            'cancelled' => 'bg-rose-50 text-rose-700',
                            default => 'bg-amber-50 text-amber-700',
                        };
                    @endphp
                    <article class="rounded-xl border border-border/70 bg-[#fbf8f3] p-3">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-charcoal">{{ $enrollment->user?->name }}</p>
                                <p class="mt-1 truncate text-xs text-charcoal/55">{{ $enrollment->course?->title }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $statusClasses }}">
                                {{ __('admin.status_'.$enrollment->status) }}
                            </span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-[11px] text-charcoal/50">
                            <span>{{ __('admin.progress') }} {{ (int) $enrollment->progress_percent }}%</span>
                            <span>{{ optional($enrollment->enrolled_at ?? $enrollment->created_at)->format('Y-m-d') }}</span>
                        </div>
                    </article>
                @empty
                    <p class="py-3 text-sm text-charcoal/60">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </section>
    </div>

    <div class="hidden md:block">
    <div class="grid gap-4 xl:grid-cols-[minmax(0,1.7fr)_repeat(3,minmax(0,1fr))]">
        <section class="admin-glass-card relative overflow-hidden p-6 sm:p-7 xl:col-span-2">
            <div class="absolute inset-y-0 start-0 w-40 bg-[radial-gradient(circle_at_center,rgba(218,110,68,0.16),transparent_68%)]"></div>
            <div class="absolute end-0 top-0 h-44 w-44 rounded-full bg-primary/10 blur-3xl"></div>

            <div class="relative">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="admin-soft-pill">
                        <x-admin.icon name="spark" class="h-4 w-4 text-accent" />
                        {{ __('admin.live_overview') }}
                    </span>
                    <span class="admin-soft-pill">{{ __('admin.last_7_days') }}</span>
                </div>

                <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
                    <div>
                        <p class="text-sm font-medium text-charcoal/[0.55]">{{ __('admin.total_enrollments') }}</p>
                        <div class="mt-3 flex items-end gap-3">
                            <span class="text-5xl font-black tracking-tight text-charcoal">{{ number_format($featuredStat['value']) }}</span>
                            <span class="mb-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $featuredStat['direction'] === 'up' ? 'bg-emerald-50 text-emerald-700' : ($featuredStat['direction'] === 'down' ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-600') }}">
                                <x-admin.icon name="trend-{{ $featuredStat['direction'] }}" class="h-4 w-4" />
                                {{ ($featuredStat['percentage'] > 0 ? '+' : '') . $featuredStat['percentage'] }}%
                            </span>
                        </div>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-charcoal/[0.65]">
                            {{ __('admin.dashboard_focus_copy') }}
                        </p>

                        <div class="mt-5 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl border border-border/70 bg-white/80 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-charcoal/[0.45]">{{ __('admin.this_week') }}</p>
                                <p class="mt-2 text-2xl font-bold text-charcoal">{{ number_format($featuredStat['period_count']) }}</p>
                                <p class="mt-1 text-xs text-charcoal/[0.55]">{{ __('admin.new_enrollments') }}</p>
                            </div>
                            <div class="rounded-2xl border border-border/70 bg-white/80 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-charcoal/[0.45]">{{ __('admin.active') }}</p>
                                <p class="mt-2 text-2xl font-bold text-charcoal">{{ number_format($performance['active_enrollments']) }}</p>
                                <p class="mt-1 text-xs text-charcoal/[0.55]">{{ __('admin.learners_in_progress') }}</p>
                            </div>
                            <div class="rounded-2xl border border-border/70 bg-white/80 p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-charcoal/[0.45]">{{ __('admin.completed') }}</p>
                                <p class="mt-2 text-2xl font-bold text-charcoal">{{ $performance['completion_rate'] }}%</p>
                                <p class="mt-1 text-xs text-charcoal/[0.55]">{{ __('admin.completed_enrollments_count', ['count' => $performance['completed_enrollments']]) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-primary/10 bg-gradient-to-br from-primary to-[#231b28] p-5 text-white shadow-[0_22px_50px_rgba(38,27,49,0.24)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-white/70">{{ __('admin.quick_actions') }}</p>
                                <h2 class="mt-1 text-xl font-bold">{{ __('admin.run_the_day') }}</h2>
                            </div>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                                <x-admin.icon name="plus" class="h-6 w-6" />
                            </span>
                        </div>

                        <div class="mt-5 grid gap-2">
                            @foreach ($quickActions as $action)
                                <a href="{{ $action['route'] }}" class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.06] px-4 py-3 text-sm font-medium text-white transition hover:bg-white/[0.12]">
                                    <span class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10">
                                            <x-admin.icon :name="$action['icon']" class="h-5 w-5" />
                                        </span>
                                        {{ $action['label'] }}
                                    </span>
                                    <x-admin.icon name="trend-up" class="h-4 w-4 text-white/[0.65]" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @foreach ($secondaryCards as $card)
            <section class="admin-metric-card overflow-hidden">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-charcoal/[0.55]">{{ $card['label'] }}</p>
                        <p class="mt-3 text-4xl font-black tracking-tight text-charcoal">{{ number_format($card['stat']['value']) }}</p>
                    </div>
                    <span class="flex h-14 w-14 items-center justify-center rounded-[22px] {{ $card['iconBg'] }} {{ $card['iconColor'] }}">
                        <x-admin.icon :name="$card['icon']" class="h-6 w-6" />
                    </span>
                </div>

                <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-black/5">
                    <div class="h-full rounded-full bg-gradient-to-r {{ $card['accent'] }}" style="width: {{ min(100, max(18, abs($card['stat']['percentage']))) }}%;"></div>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3">
                    <p class="text-sm text-charcoal/60">{{ $card['support'] }}</p>
                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $card['stat']['direction'] === 'up' ? 'bg-emerald-50 text-emerald-700' : ($card['stat']['direction'] === 'down' ? 'bg-rose-50 text-rose-700' : 'bg-slate-100 text-slate-600') }}">
                        <x-admin.icon name="trend-{{ $card['stat']['direction'] }}" class="h-4 w-4" />
                        {{ ($card['stat']['percentage'] > 0 ? '+' : '') . $card['stat']['percentage'] }}%
                    </span>
                </div>
                <p class="mt-2 text-xs font-medium text-charcoal/40">{{ __('admin.vs_last_week') }}</p>
            </section>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.65fr)_minmax(320px,1fr)]">
        <section class="admin-glass-card p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-charcoal">{{ __('admin.weekly_activity') }}</h2>
                    <p class="mt-1 text-sm text-charcoal/[0.58]">{{ __('admin.weekly_activity_subtitle') }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-charcoal/60">
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#f1eafe] px-3 py-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#775bd4]"></span>
                        {{ __('admin.signups') }} {{ $activityTotals['users'] }}
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#fff1e6] px-3 py-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#e68857]"></span>
                        {{ __('admin.enrollments') }} {{ $activityTotals['enrollments'] }}
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#e8f6fa] px-3 py-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#2e8398]"></span>
                        {{ __('admin.messages') }} {{ $activityTotals['messages'] }}
                    </span>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-7 gap-3">
                @foreach ($activity as $day)
                    <div class="rounded-[24px] border border-border/60 bg-[#fbf8f3] px-3 pb-3 pt-4 text-center">
                        <div class="mx-auto flex h-44 items-end justify-center gap-1">
                            @foreach ([
                                ['value' => $day['users'], 'color' => '#775bd4'],
                                ['value' => $day['enrollments'], 'color' => '#e68857'],
                                ['value' => $day['messages'], 'color' => '#2e8398'],
                            ] as $bar)
                                @php
                                    $height = max(10, (int) round(($bar['value'] / $chartMax) * 100));
                                @endphp
                                <div class="w-3 rounded-full" style="height: {{ $height }}%; background: {{ $bar['color'] }};"></div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-sm font-semibold text-charcoal">{{ $day['label'] }}</p>
                        <p class="mt-1 text-xs text-charcoal/[0.45]">{{ $day['full_label'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="admin-glass-card p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-charcoal">{{ __('admin.performance_snapshot') }}</h2>
                    <p class="mt-1 text-sm text-charcoal/[0.58]">{{ __('admin.performance_subtitle') }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/[0.08] text-primary">
                    <x-admin.icon name="chart" class="h-6 w-6" />
                </span>
            </div>

            <div class="mt-6 space-y-5">
                @foreach ($performanceItems as $item)
                    <div>
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-charcoal">{{ $item['label'] }}</p>
                                <p class="mt-1 text-xs text-charcoal/50">{{ $item['hint'] }}</p>
                            </div>
                            <span class="text-lg font-bold text-charcoal">{{ $item['value'] }}%</span>
                        </div>
                        <div class="mt-3 h-2 overflow-hidden rounded-full bg-black/5">
                            <div class="h-full rounded-full bg-gradient-to-r from-primary via-primary-light to-accent" style="width: {{ $item['value'] }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl border border-border/70 bg-[#fbf8f3] p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-charcoal/[0.45]">{{ __('admin.featured') }}</p>
                    <p class="mt-2 text-2xl font-bold text-charcoal">{{ number_format($performance['featured_courses']) }}</p>
                    <p class="mt-1 text-xs text-charcoal/[0.55]">{{ __('admin.featured_courses') }}</p>
                </div>
                <div class="rounded-2xl border border-border/70 bg-[#fbf8f3] p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-charcoal/[0.45]">{{ __('admin.cancelled') }}</p>
                    <p class="mt-2 text-2xl font-bold text-charcoal">{{ number_format($performance['cancelled_enrollments']) }}</p>
                    <p class="mt-1 text-xs text-charcoal/[0.55]">{{ __('admin.cancelled_enrollments') }}</p>
                </div>
            </div>
        </section>
    </div>

    @if ($searchResults['query'] !== '')
        <section class="admin-glass-card mt-6 p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-charcoal">{{ __('admin.search_results') }}</h2>
                    <p class="mt-1 text-sm text-charcoal/[0.58]">{{ __('admin.search_results_for', ['query' => $searchResults['query']]) }}</p>
                </div>
                <span class="rounded-full bg-primary/[0.08] px-3 py-2 text-sm font-semibold text-primary">
                    {{ $searchResults['total'] }} {{ __('admin.matches') }}
                </span>
            </div>

            @if ($searchResults['total'] === 0)
                <p class="mt-6 rounded-2xl border border-dashed border-border bg-[#fbf8f3] p-5 text-sm text-charcoal/60">
                    {{ __('admin.no_search_results') }}
                </p>
            @else
                <div class="mt-6 grid gap-4 xl:grid-cols-3">
                    <div class="rounded-[24px] border border-border/70 bg-[#fbf8f3] p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#f1eafe] text-[#5e44a7]">
                                <x-admin.icon name="users" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-bold text-charcoal">{{ __('admin.users') }}</h3>
                                <p class="text-xs text-charcoal/50">{{ $searchResults['users']->count() }} {{ __('admin.matches') }}</p>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @forelse ($searchResults['users'] as $user)
                                <a href="{{ route('admin.users.edit', $user) }}" class="flex items-center justify-between rounded-2xl border border-white/80 bg-white px-4 py-3 text-sm shadow-sm transition hover:-translate-y-0.5">
                                    <span>
                                        <span class="block font-semibold text-charcoal">{{ $user->name }}</span>
                                        <span class="mt-1 block text-xs text-charcoal/[0.55]">{{ $user->email }}</span>
                                    </span>
                                    <span class="text-xs font-semibold text-primary">{{ __('admin.manage') }}</span>
                                </a>
                            @empty
                                <p class="text-sm text-charcoal/[0.55]">{{ __('admin.no_data') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-[24px] border border-border/70 bg-[#fbf8f3] p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#fff1e6] text-[#cf6a37]">
                                <x-admin.icon name="courses" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-bold text-charcoal">{{ __('admin.courses') }}</h3>
                                <p class="text-xs text-charcoal/50">{{ $searchResults['courses']->count() }} {{ __('admin.matches') }}</p>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @forelse ($searchResults['courses'] as $course)
                                <a href="{{ route('admin.courses.edit', $course) }}" class="flex items-center justify-between rounded-2xl border border-white/80 bg-white px-4 py-3 text-sm shadow-sm transition hover:-translate-y-0.5">
                                    <span>
                                        <span class="block font-semibold text-charcoal">{{ $course->title }}</span>
                                        <span class="mt-1 block text-xs text-charcoal/[0.55]">{{ $course->slug }}</span>
                                    </span>
                                    <span class="text-xs font-semibold text-primary">{{ __('admin.manage') }}</span>
                                </a>
                            @empty
                                <p class="text-sm text-charcoal/[0.55]">{{ __('admin.no_data') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-[24px] border border-border/70 bg-[#fbf8f3] p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#e8f6fa] text-[#246477]">
                                <x-admin.icon name="messages" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-bold text-charcoal">{{ __('admin.messages') }}</h3>
                                <p class="text-xs text-charcoal/50">{{ $searchResults['messages']->count() }} {{ __('admin.matches') }}</p>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @forelse ($searchResults['messages'] as $message)
                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="flex items-center justify-between rounded-2xl border border-white/80 bg-white px-4 py-3 text-sm shadow-sm transition hover:-translate-y-0.5">
                                    <span>
                                        <span class="block font-semibold text-charcoal">{{ $message->name }}</span>
                                        <span class="mt-1 block text-xs text-charcoal/[0.55]">{{ $message->subject }}</span>
                                    </span>
                                    <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $message->is_read ? 'bg-slate-100 text-slate-600' : 'bg-emerald-50 text-emerald-700' }}">
                                        {{ $message->is_read ? __('admin.read') : __('admin.unread') }}
                                    </span>
                                </a>
                            @empty
                                <p class="text-sm text-charcoal/[0.55]">{{ __('admin.no_data') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </section>
    @endif

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <section class="admin-glass-card p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-charcoal">{{ __('admin.top_courses') }}</h2>
                    <p class="mt-1 text-sm text-charcoal/[0.58]">{{ __('admin.best_enrollment_volume') }}</p>
                </div>
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#fff1e6] text-[#cf6a37]">
                    <x-admin.icon name="courses" class="h-6 w-6" />
                </span>
            </div>

            <div class="mt-6 space-y-4">
                @forelse ($topCourses as $course)
                    @php
                        $share = max(14, (int) round(($course->enrollments_count / $topCourseMax) * 100));
                    @endphp
                    <div class="rounded-2xl border border-border/70 bg-[#fbf8f3] p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-charcoal">{{ $course->title }}</p>
                                <p class="mt-1 text-xs text-charcoal/50">{{ $course->slug }}</p>
                            </div>
                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-charcoal/70 shadow-sm">
                                {{ $course->enrollments_count }} {{ __('admin.enrollments_count') }}
                            </span>
                        </div>
                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-white">
                            <div class="h-full rounded-full bg-gradient-to-r from-accent via-[#f0a06f] to-[#f7cfac]" style="width: {{ $share }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-charcoal/60">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </section>

        <section class="admin-glass-card p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-charcoal">{{ __('admin.latest_enrollments') }}</h2>
                    <p class="mt-1 text-sm text-charcoal/[0.58]">{{ __('admin.latest_enrollments_subtitle') }}</p>
                </div>
                <a href="{{ route('admin.enrollments.index') }}" class="text-sm font-semibold text-primary">{{ __('admin.manage') }}</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($recentEnrollments as $enrollment)
                    @php
                        $statusClasses = match ($enrollment->status) {
                            'completed' => 'bg-emerald-50 text-emerald-700',
                            'cancelled' => 'bg-rose-50 text-rose-700',
                            default => 'bg-amber-50 text-amber-700',
                        };
                    @endphp
                    <div class="rounded-[22px] border border-border/70 bg-[#fbf8f3] p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-charcoal">{{ $enrollment->user?->name }}</p>
                                <p class="mt-1 text-sm text-charcoal/[0.58]">{{ $enrollment->course?->title }}</p>
                            </div>
                            <span class="rounded-full px-3 py-1 text-[11px] font-semibold {{ $statusClasses }}">
                                {{ __('admin.status_'.$enrollment->status) }}
                            </span>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs text-charcoal/50">
                            <span>{{ __('admin.progress') }} {{ (int) $enrollment->progress_percent }}%</span>
                            <span>{{ optional($enrollment->enrolled_at ?? $enrollment->created_at)->format('Y-m-d') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-charcoal/60">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </section>

        <section class="admin-glass-card p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-charcoal">{{ __('admin.latest_messages') }}</h2>
                    <p class="mt-1 text-sm text-charcoal/[0.58]">{{ __('admin.latest_messages_subtitle') }}</p>
                </div>
                <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-semibold text-primary">{{ __('admin.manage') }}</a>
            </div>

            <div class="mt-6 divide-y divide-border/70">
                @forelse ($recentMessages as $message)
                    <a href="{{ route('admin.contact-messages.show', $message) }}" class="flex items-start justify-between gap-3 py-4 first:pt-0 last:pb-0">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="truncate font-semibold text-charcoal">{{ $message->name }}</p>
                                <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $message->is_read ? 'bg-slate-100 text-slate-600' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ $message->is_read ? __('admin.read') : __('admin.unread') }}
                                </span>
                            </div>
                            <p class="mt-2 truncate text-sm text-charcoal/[0.58]">{{ $message->subject }}</p>
                            <p class="mt-1 text-xs text-charcoal/[0.45]">{{ $message->email }}</p>
                        </div>
                        <span class="whitespace-nowrap text-xs text-charcoal/[0.45]">{{ $message->created_at->format('Y-m-d') }}</span>
                    </a>
                @empty
                    <p class="text-sm text-charcoal/60">{{ __('admin.no_data') }}</p>
                @endforelse
            </div>
        </section>
    </div>
    </div>
@endsection
