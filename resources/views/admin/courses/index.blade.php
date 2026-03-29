@extends('layouts.admin')

@section('page-title', __('admin.courses'))

@section('content')
    <div class="space-y-4">
        <div class="card-surface p-4 sm:p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <form action="{{ route('admin.courses.index') }}" method="get" class="grid gap-2 sm:grid-cols-[minmax(0,1fr)_auto] sm:w-[26rem]">
                    <label for="courses-search" class="sr-only">{{ __('admin.search') }}</label>
                    <input
                        id="courses-search"
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="{{ __('admin.search') }}"
                        class="h-11 w-full rounded-xl border border-border bg-white px-4 text-sm text-charcoal placeholder:text-charcoal/45 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                    >
                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center rounded-xl border border-border bg-white px-5 text-sm font-semibold text-charcoal transition hover:bg-cream"
                    >
                        {{ __('admin.search') }}
                    </button>
                </form>

                <a
                    href="{{ route('admin.courses.create') }}"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/20"
                >
                    {{ __('admin.add_course') }}
                </a>
            </div>
        </div>

        <div class="space-y-3">
            @forelse ($courses as $course)
                @php
                    $courseTitle = $course->title;
                    $courseLevel = __('levels.'.$course->level);
                @endphp

                <article class="card-surface p-4 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <x-admin.icon name="courses" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-charcoal/45">#{{ $course->id }}</p>
                                <h3 class="mt-1 truncate text-base font-bold text-charcoal">{{ $courseTitle }}</h3>
                                <p class="mt-1 truncate text-sm text-charcoal/70">{{ $course->instructor?->name ?: __('admin.none') }}</p>
                            </div>
                        </div>

                        <span class="inline-flex shrink-0 items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $course->is_published ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                            {{ $course->is_published ? __('admin.published') : __('admin.draft') }}
                        </span>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-charcoal/70">
                        <span class="inline-flex items-center gap-1 rounded-lg bg-cream px-3 py-1.5">
                            <x-admin.icon name="chart" class="h-4 w-4 text-charcoal/45" />
                            {{ $courseLevel }}
                        </span>

                        @if ($course->is_featured)
                            <span class="inline-flex items-center gap-1 rounded-lg border border-accent/20 bg-accent/10 px-3 py-1.5 text-accent">
                                <x-admin.icon name="spark" class="h-4 w-4" />
                                {{ __('admin.featured') }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a
                            href="{{ route('admin.courses.edit', $course) }}"
                            class="inline-flex min-h-11 items-center justify-center rounded-xl border border-primary/20 bg-primary/10 px-3 text-sm font-semibold text-primary transition hover:bg-primary/15"
                        >
                            {{ __('admin.edit') }}
                        </a>

                        <form action="{{ route('admin.courses.destroy', $course) }}" method="post">
                            @csrf
                            @method('delete')
                            <button
                                type="submit"
                                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-rose-200 bg-rose-50 px-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                            >
                                {{ __('admin.delete') }}
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="card-surface p-6 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</div>
            @endforelse
        </div>

        <div class="card-surface px-4 py-3 sm:px-5">
            {{ $courses->links() }}
        </div>
    </div>
@endsection
