@extends('layouts.admin')

@section('page-title', __('admin.messages'))

@section('content')
    <div class="space-y-4">
        <div class="card-surface p-4 sm:p-5">
            <form action="{{ route('admin.contact-messages.index') }}" method="get" class="grid gap-2 sm:w-[22rem] sm:grid-cols-[minmax(0,1fr)_auto]">
                <label for="messages-status" class="sr-only">{{ __('admin.status') }}</label>
                <select
                    id="messages-status"
                    name="status"
                    class="h-11 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                >
                    <option value="">{{ __('admin.all_statuses') }}</option>
                    <option value="read" @selected(request('status') === 'read')>{{ __('admin.read') }}</option>
                    <option value="unread" @selected(request('status') === 'unread')>{{ __('admin.unread') }}</option>
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
            @forelse ($messages as $message)
                <article class="card-surface p-4 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <x-admin.icon name="messages" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0">
                                <h3 class="truncate text-base font-bold text-charcoal">{{ $message->name }}</h3>
                                <p class="mt-1 truncate text-sm text-charcoal/70">{{ $message->subject }}</p>
                            </div>
                        </div>

                        <span class="inline-flex shrink-0 items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $message->is_read ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                            {{ $message->is_read ? __('admin.read') : __('admin.unread') }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-charcoal/70">
                        <div class="flex items-center gap-2" dir="ltr">
                            <x-admin.icon name="users" class="h-4 w-4 text-charcoal/45" />
                            <span class="truncate">{{ $message->email }}</span>
                        </div>

                        <div class="flex items-start gap-2">
                            <x-admin.icon name="messages" class="mt-0.5 h-4 w-4 shrink-0 text-charcoal/45" />
                            <p class="text-charcoal/65">{{ \Illuminate\Support\Str::limit($message->message, 120) }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a
                            href="{{ route('admin.contact-messages.show', $message) }}"
                            class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-primary/20 bg-primary/10 px-3 text-sm font-semibold text-primary transition hover:bg-primary/15"
                        >
                            {{ __('admin.view') }}
                        </a>
                    </div>
                </article>
            @empty
                <div class="card-surface p-6 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</div>
            @endforelse
        </div>

        <div class="card-surface px-4 py-3 sm:px-5">
            {{ $messages->links() }}
        </div>
    </div>
@endsection
