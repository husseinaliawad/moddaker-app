@extends('layouts.admin')

@section('page-title', __('admin.categories'))

@section('content')
    <div class="space-y-4">
        <div class="card-surface p-4 sm:p-5">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <form action="{{ route('admin.categories.index') }}" method="get" class="grid gap-2 sm:grid-cols-[minmax(0,1fr)_auto] md:w-[28rem]">
                    <label for="categories-search" class="sr-only">{{ __('admin.search') }}</label>
                    <input
                        id="categories-search"
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="{{ __('admin.search') }}"
                        class="h-11 w-full rounded-xl border border-border bg-white px-4 text-sm text-charcoal placeholder:text-charcoal/45 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                    >
                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl border border-border bg-white px-5 text-sm font-semibold text-charcoal transition hover:bg-cream">
                        {{ __('admin.search') }}
                    </button>
                </form>

                <a
                    href="{{ route('admin.categories.create') }}"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/20"
                >
                    {{ __('admin.add_category') }}
                </a>
            </div>
        </div>

        <div class="card-surface overflow-hidden">
            <div class="divide-y divide-border/70 md:hidden">
                @forelse ($categories as $category)
                    @php
                        $categoryName = $category->translations->firstWhere('locale', 'ar')?->name ?? '-';
                        $isActive = (bool) $category->is_active;
                    @endphp

                    <article class="p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-charcoal/45">#{{ $category->id }}</p>
                                <h3 class="mt-1 truncate text-base font-bold text-charcoal">{{ $categoryName }}</h3>
                            </div>

                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $isActive ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
                                {{ $isActive ? __('admin.active') : __('admin.inactive') }}
                            </span>
                        </div>

                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-4">
                                <dt class="shrink-0 text-charcoal/55">{{ __('admin.name_ar') }}</dt>
                                <dd class="truncate font-semibold text-charcoal">{{ $categoryName }}</dd>
                            </div>

                            <div class="flex items-center justify-between gap-4">
                                <dt class="shrink-0 text-charcoal/55">Slug</dt>
                                <dd class="max-w-[65%] truncate font-mono text-[13px] text-charcoal/80" dir="ltr">{{ $category->slug }}</dd>
                            </div>
                        </dl>

                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <a
                                href="{{ route('admin.categories.edit', $category) }}"
                                class="inline-flex min-h-11 items-center justify-center rounded-xl border border-primary/20 bg-primary/10 px-3 text-sm font-semibold text-primary transition hover:bg-primary/15"
                            >
                                {{ __('admin.edit') }}
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
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
                    <div class="p-6 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</div>
                @endforelse
            </div>

            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-separate border-spacing-0 text-sm">
                        <thead>
                            <tr class="bg-cream/55 text-start text-xs font-semibold uppercase tracking-[0.14em] text-charcoal/55">
                                <th class="border-b border-border px-4 py-3">#</th>
                                <th class="border-b border-border px-4 py-3">{{ __('admin.name_ar') }}</th>
                                <th class="border-b border-border px-4 py-3">Slug</th>
                                <th class="border-b border-border px-4 py-3">{{ __('admin.status') }}</th>
                                <th class="border-b border-border px-4 py-3">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody class="[&>tr:last-child>td]:border-b-0">
                            @forelse ($categories as $category)
                                @php
                                    $categoryName = $category->translations->firstWhere('locale', 'ar')?->name ?? '-';
                                    $isActive = (bool) $category->is_active;
                                @endphp

                                <tr class="transition hover:bg-cream/35">
                                    <td class="border-b border-border/70 px-4 py-4 align-middle font-semibold text-charcoal/80">{{ $category->id }}</td>
                                    <td class="border-b border-border/70 px-4 py-4 align-middle font-semibold text-charcoal">{{ $categoryName }}</td>
                                    <td class="border-b border-border/70 px-4 py-4 align-middle font-mono text-[13px] text-charcoal/80" dir="ltr">{{ $category->slug }}</td>
                                    <td class="border-b border-border/70 px-4 py-4 align-middle">
                                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $isActive ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
                                            {{ $isActive ? __('admin.active') : __('admin.inactive') }}
                                        </span>
                                    </td>
                                    <td class="border-b border-border/70 px-4 py-4 align-middle">
                                        <div class="flex items-center gap-2">
                                            <a
                                                href="{{ route('admin.categories.edit', $category) }}"
                                                class="inline-flex min-h-10 items-center justify-center rounded-lg border border-primary/20 bg-primary/10 px-3 text-sm font-semibold text-primary transition hover:bg-primary/15"
                                            >
                                                {{ __('admin.edit') }}
                                            </a>

                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button
                                                    type="submit"
                                                    class="inline-flex min-h-10 items-center justify-center rounded-lg border border-rose-200 bg-rose-50 px-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                                                >
                                                    {{ __('admin.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-surface px-4 py-3 sm:px-5">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
