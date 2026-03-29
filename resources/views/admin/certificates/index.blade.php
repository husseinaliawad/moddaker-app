@extends('layouts.admin')

@section('page-title', __('admin.certificates'))

@section('content')
    <div class="grid gap-4 lg:grid-cols-[minmax(0,22rem)_minmax(0,1fr)]">
        <form action="{{ route('admin.certificates.store') }}" method="post" class="card-surface p-4 sm:p-5">
            @csrf
            <div class="flex items-center gap-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <x-admin.icon name="certificates" class="h-5 w-5" />
                </span>
                <h2 class="text-base font-bold text-charcoal">{{ __('admin.issue_certificate') }}</h2>
            </div>

            <div class="mt-4 space-y-3">
                <label for="certificate-user" class="sr-only">{{ __('admin.select_user') }}</label>
                <select
                    id="certificate-user"
                    name="user_id"
                    class="h-11 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                    required
                >
                    <option value="">{{ __('admin.select_user') }}</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <label for="certificate-course" class="sr-only">{{ __('admin.select_course') }}</label>
                <select
                    id="certificate-course"
                    name="course_id"
                    class="h-11 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                    required
                >
                    <option value="">{{ __('admin.select_course') }}</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/20"
                >
                    {{ __('admin.save') }}
                </button>
            </div>
        </form>

        <div class="space-y-3">
            <div class="card-surface p-4 sm:p-5">
                <h2 class="text-base font-bold text-charcoal">{{ __('admin.certificates_list') }}</h2>
            </div>

            @forelse ($certificates as $certificate)
                <article class="card-surface p-4 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <x-admin.icon name="certificates" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0">
                                <h3 class="truncate text-base font-bold text-charcoal">{{ $certificate->user->name }}</h3>
                                <p class="mt-1 truncate text-sm text-charcoal/70">{{ $certificate->course->title }}</p>
                            </div>
                        </div>

                        <span class="inline-flex shrink-0 items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ __('student.issued_at') }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-charcoal/70">
                        <div class="flex items-center gap-2">
                            <x-admin.icon name="shield" class="h-4 w-4 text-charcoal/45" />
                            <span dir="ltr" class="truncate">{{ $certificate->serial_number }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <x-admin.icon name="chart" class="h-4 w-4 text-charcoal/45" />
                            <span>{{ $certificate->issued_at?->format('Y-m-d') ?: '-' }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a
                            href="{{ route('admin.users.edit', $certificate->user) }}"
                            class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-primary/20 bg-primary/10 px-3 text-sm font-semibold text-primary transition hover:bg-primary/15"
                        >
                            {{ __('admin.edit') }}
                        </a>
                    </div>
                </article>
            @empty
                <div class="card-surface p-6 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</div>
            @endforelse

            <div class="card-surface px-4 py-3 sm:px-5">
                {{ $certificates->links() }}
            </div>
        </div>
    </div>
@endsection
