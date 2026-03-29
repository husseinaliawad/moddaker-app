@extends('layouts.student')

@section('page-title', __('student.progress'))

@section('content')
    <div class="space-y-4">
        @forelse ($enrollments as $enrollment)
            <article class="card-surface p-5">
                <h2 class="text-lg font-bold text-charcoal">{{ $enrollment->course->title }}</h2>
                <div class="mt-2 h-3 rounded-full bg-cream">
                    <div class="h-3 rounded-full bg-primary" style="width: {{ $enrollment->progress_percent }}%"></div>
                </div>
                <p class="mt-2 text-sm text-charcoal/60">{{ __('student.progress_value', ['value' => $enrollment->progress_percent]) }}</p>

                <div class="mt-4 text-sm text-charcoal/70">
                    {{ __('student.completed_lessons_count', ['count' => $enrollment->progresses->where('is_completed', true)->count()]) }}
                </div>
            </article>
        @empty
            <div class="card-surface p-6 text-center text-charcoal/60">{{ __('student.no_progress') }}</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $enrollments->links() }}</div>
@endsection

