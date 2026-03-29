@extends('layouts.admin')

@section('page-title', __('admin.pages'))

@section('content')
    <div class="card-surface p-5">
        <div class="mb-4 flex items-center justify-between">
            <form class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('admin.search') }}" class="rounded-xl border-border">
                <button class="btn-secondary text-sm">{{ __('admin.search') }}</button>
            </form>
            <a href="{{ route('admin.pages.create') }}" class="btn-primary text-sm">{{ __('admin.add_page') }}</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-border text-start text-charcoal/60">
                        <th class="px-3 py-2">#</th>
                        <th class="px-3 py-2">Slug</th>
                        <th class="px-3 py-2">{{ __('admin.title_ar') }}</th>
                        <th class="px-3 py-2">{{ __('admin.status') }}</th>
                        <th class="px-3 py-2">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr class="border-b border-border/70">
                            <td class="px-3 py-2">{{ $page->id }}</td>
                            <td class="px-3 py-2">{{ $page->slug }}</td>
                            <td class="px-3 py-2">{{ $page->translations->firstWhere('locale', 'ar')?->title }}</td>
                            <td class="px-3 py-2">
                                <span class="rounded-full px-2 py-1 text-xs {{ $page->is_published ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $page->is_published ? __('admin.published') : __('admin.draft') }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="rounded-lg bg-primary/10 px-2 py-1 text-primary">{{ __('admin.edit') }}</a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="rounded-lg bg-red-100 px-2 py-1 text-red-700">{{ __('admin.delete') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pages->links() }}</div>
    </div>
@endsection

