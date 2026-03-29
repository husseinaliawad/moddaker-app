@extends('layouts.student')

@section('page-title', __('student.certificates'))

@section('content')
    <div class="space-y-4">
        @forelse ($certificates as $certificate)
            <article class="card-surface p-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-charcoal">{{ $certificate->course->title }}</h2>
                        <p class="text-sm text-charcoal/60">{{ __('student.serial_number') }}: {{ $certificate->serial_number }}</p>
                        <p class="text-sm text-charcoal/60">{{ __('student.issued_at') }}: {{ $certificate->issued_at?->format('Y-m-d') }}</p>
                    </div>
                    @if ($certificate->file_path)
                        <a href="{{ asset('storage/'.$certificate->file_path) }}" target="_blank" class="btn-primary text-sm">
                            {{ __('student.download_certificate') }}
                        </a>
                    @endif
                </div>
            </article>
        @empty
            <div class="card-surface p-6 text-center text-charcoal/60">{{ __('student.no_certificates') }}</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $certificates->links() }}</div>
@endsection

