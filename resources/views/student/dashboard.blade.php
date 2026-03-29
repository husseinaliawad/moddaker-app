@extends('layouts.student')

@section('page-title', __('student.dashboard'))

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="card-surface p-5">
            <div class="text-sm text-charcoal/60">{{ __('student.enrolled_courses') }}</div>
            <div class="mt-2 text-3xl font-bold text-primary">{{ $stats['enrolled_courses'] }}</div>
        </div>
        <div class="card-surface p-5">
            <div class="text-sm text-charcoal/60">{{ __('student.completed_courses') }}</div>
            <div class="mt-2 text-3xl font-bold text-primary">{{ $stats['completed_courses'] }}</div>
        </div>
        <div class="card-surface p-5">
            <div class="text-sm text-charcoal/60">{{ __('student.average_progress') }}</div>
            <div class="mt-2 text-3xl font-bold text-primary">{{ $stats['average_progress'] }}%</div>
        </div>
        <div class="card-surface p-5">
            <div class="text-sm text-charcoal/60">{{ __('student.certificates') }}</div>
            <div class="mt-2 text-3xl font-bold text-primary">{{ $stats['certificates'] }}</div>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="card-surface p-6">
            <h2 class="text-xl font-bold text-charcoal">{{ __('student.current_courses') }}</h2>
            <div class="mt-4 space-y-3">
                @forelse ($enrollments->take(5) as $enrollment)
                    <div class="rounded-xl bg-cream p-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">{{ $enrollment->course->title }}</span>
                            <span class="text-sm text-primary">{{ $enrollment->progress_percent }}%</span>
                        </div>
                        <div class="mt-2 h-2 rounded-full bg-white">
                            <div class="h-2 rounded-full bg-primary" style="width: {{ $enrollment->progress_percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-charcoal/60">{{ __('student.no_enrollments') }}</p>
                @endforelse
            </div>
        </div>

        <div class="card-surface p-6">
            <h2 class="text-xl font-bold text-charcoal">{{ __('student.recent_lessons') }}</h2>
            <div class="mt-4 space-y-3">
                @forelse ($recentLessons as $progress)
                    <div class="rounded-xl bg-cream p-3">
                        <div class="font-semibold">{{ $progress->lesson->title }}</div>
                        <div class="text-xs text-charcoal/60">{{ $progress->lesson->course->title }}</div>
                    </div>
                @empty
                    <p class="text-sm text-charcoal/60">{{ __('student.no_progress') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

