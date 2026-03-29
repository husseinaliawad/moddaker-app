@extends('layouts.admin')

@section('page-title', __('admin.enrollments'))

@section('content')
    <div class="space-y-4">
        <div class="card-surface p-4 sm:p-5">
            <form action="{{ route('admin.enrollments.index') }}" method="get" class="grid gap-2 sm:w-[22rem] sm:grid-cols-[minmax(0,1fr)_auto]">
                <label for="enrollments-status" class="sr-only">{{ __('admin.status') }}</label>
                <select
                    id="enrollments-status"
                    name="status"
                    class="h-11 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                >
                    <option value="">{{ __('admin.all_statuses') }}</option>
                    @foreach (['active', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ __('admin.status_'.$status) }}</option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center rounded-xl border border-border bg-white px-5 text-sm font-semibold text-charcoal transition hover:bg-cream"
                >
                    {{ __('admin.filter') }}
                </button>
            </form>
        </div>

        <div class="space-y-3">
            @forelse ($enrollments as $enrollment)
                @php
                    $progressValue = max(0, min(100, (float) $enrollment->progress_percent));
                    $statusClass = match ($enrollment->status) {
                        'completed' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                        'cancelled' => 'border-rose-200 bg-rose-50 text-rose-700',
                        default => 'border-sky-200 bg-sky-50 text-sky-700',
                    };
                    $progressBarClass = match ($enrollment->status) {
                        'completed' => 'bg-emerald-500',
                        'cancelled' => 'bg-rose-500',
                        default => 'bg-primary',
                    };
                @endphp

                <article class="card-surface p-4 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <x-admin.icon name="enrollments" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0">
                                <h3 class="truncate text-base font-bold text-charcoal">{{ $enrollment->user->name }}</h3>
                                <p class="mt-1 truncate text-sm text-charcoal/70">{{ $enrollment->course->title }}</p>
                            </div>
                        </div>

                        <span class="inline-flex shrink-0 items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                            {{ __('admin.status_'.$enrollment->status) }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <div class="mb-1 flex items-center justify-between text-xs text-charcoal/65">
                            <span>{{ __('student.progress') }}</span>
                            <span dir="ltr">{{ number_format($progressValue, 0) }}%</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-creamDark">
                            <div
                                class="h-full rounded-full {{ $progressBarClass }}"
                                style="width: {{ $progressValue }}%"
                                role="progressbar"
                                aria-valuenow="{{ number_format($progressValue, 0) }}"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                aria-label="{{ __('student.progress') }}"
                            ></div>
                        </div>
                    </div>

                    <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="post" class="mt-4 grid gap-2 sm:grid-cols-[minmax(0,1fr)_7rem_auto]">
                        @csrf
                        @method('patch')

                        <label for="enrollment-status-{{ $enrollment->id }}" class="sr-only">{{ __('admin.status') }}</label>
                        <select
                            id="enrollment-status-{{ $enrollment->id }}"
                            name="status"
                            class="h-10 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                        >
                            @foreach (['active', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected($enrollment->status === $status)>{{ __('admin.status_'.$status) }}</option>
                            @endforeach
                        </select>

                        <label for="enrollment-progress-{{ $enrollment->id }}" class="sr-only">{{ __('student.progress') }}</label>
                        <input
                            id="enrollment-progress-{{ $enrollment->id }}"
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            name="progress_percent"
                            value="{{ $enrollment->progress_percent }}"
                            class="h-10 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                        >

                        <button
                            type="submit"
                            class="inline-flex h-10 items-center justify-center rounded-xl bg-primary px-4 text-sm font-semibold text-white transition hover:bg-primary/90"
                        >
                            {{ __('admin.update') }}
                        </button>
                    </form>
                </article>
            @empty
                <div class="card-surface p-6 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</div>
            @endforelse
        </div>

        <div class="card-surface px-4 py-3 sm:px-5">
            {{ $enrollments->links() }}
        </div>
    </div>
@endsection
