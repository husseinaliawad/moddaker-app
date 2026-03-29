@extends('layouts.student')

@section('page-title', __('student.my_courses'))

@section('content')
    <div class="space-y-4">
        @forelse ($enrollments as $enrollment)
            <article class="card-surface p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-charcoal">{{ $enrollment->course->title }}</h2>
                        <p class="text-sm text-charcoal/60">{{ __('levels.'.$enrollment->course->level) }}</p>
                    </div>
                    <a href="{{ route('courses.show', $enrollment->course) }}" class="btn-primary text-sm">
                        {{ __('student.continue_learning') }}
                    </a>
                </div>
            </article>
        @empty
            <div class="card-surface p-6 text-center text-charcoal/60">{{ __('student.no_enrollments') }}</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $enrollments->links() }}</div>
@endsection

