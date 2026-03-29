@extends('layouts.admin')

@section('page-title', __('admin.roles_permissions'))

@section('content')
    <div class="grid gap-4 lg:grid-cols-[minmax(0,22rem)_minmax(0,1fr)]">
        <form action="{{ route('admin.roles.store') }}" method="post" class="card-surface p-4 sm:p-5">
            @csrf
            <div class="flex items-center gap-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <x-admin.icon name="shield" class="h-5 w-5" />
                </span>
                <h2 class="text-base font-bold text-charcoal">{{ __('admin.add_role') }}</h2>
            </div>

            <div class="mt-4 space-y-3">
                <label for="role-name" class="sr-only">{{ __('admin.role_name') }}</label>
                <input
                    id="role-name"
                    type="text"
                    name="name"
                    placeholder="{{ __('admin.role_name') }}"
                    class="h-11 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal placeholder:text-charcoal/45 focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                    required
                >

                <label for="role-permissions" class="sr-only">{{ __('admin.roles_permissions') }}</label>
                <select
                    id="role-permissions"
                    name="permissions[]"
                    multiple
                    class="w-full rounded-xl border border-border bg-white px-3 py-2 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                >
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
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
                <h2 class="text-base font-bold text-charcoal">{{ __('admin.roles_list') }}</h2>
            </div>

            @forelse ($roles as $role)
                @php
                    $isSystemRole = $role->name === 'admin';
                    $permissionNames = $role->permissions->pluck('name');
                @endphp

                <article class="card-surface p-4 sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <x-admin.icon name="shield" class="h-5 w-5" />
                            </span>

                            <div class="min-w-0">
                                <h3 class="truncate text-base font-bold text-charcoal">{{ $role->name }}</h3>
                                <p class="mt-1 text-sm text-charcoal/70">{{ $permissionNames->count() }} {{ __('admin.roles_permissions') }}</p>
                            </div>
                        </div>

                        <span class="inline-flex shrink-0 items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $isSystemRole ? 'border-primary/20 bg-primary/10 text-primary' : 'border-slate-200 bg-slate-50 text-slate-700' }}">
                            {{ $isSystemRole ? 'System' : 'Custom' }}
                        </span>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @forelse ($permissionNames as $permissionName)
                            <span class="inline-flex items-center rounded-full border border-border bg-white px-2.5 py-1 text-xs font-medium text-charcoal/75">
                                {{ $permissionName }}
                            </span>
                        @empty
                            <span class="text-sm text-charcoal/55">-</span>
                        @endforelse
                    </div>

                    <form action="{{ route('admin.roles.update', $role) }}" method="post" class="mt-4 space-y-2">
                        @csrf
                        @method('patch')

                        <label for="role-name-{{ $role->id }}" class="sr-only">{{ __('admin.role_name') }}</label>
                        <input
                            id="role-name-{{ $role->id }}"
                            type="text"
                            name="name"
                            value="{{ $role->name }}"
                            class="h-10 w-full rounded-xl border border-border bg-white px-3 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                            required
                        >

                        <label for="role-permissions-{{ $role->id }}" class="sr-only">{{ __('admin.roles_permissions') }}</label>
                        <select
                            id="role-permissions-{{ $role->id }}"
                            name="permissions[]"
                            multiple
                            class="w-full rounded-xl border border-border bg-white px-3 py-2 text-sm text-charcoal focus:border-primary/35 focus:outline-none focus:ring-4 focus:ring-primary/10"
                        >
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}" @selected($role->permissions->pluck('name')->contains($permission->name))>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="grid grid-cols-2 gap-2">
                            <button
                                type="submit"
                                class="inline-flex min-h-10 items-center justify-center rounded-xl border border-primary/20 bg-primary/10 px-3 text-sm font-semibold text-primary transition hover:bg-primary/15"
                            >
                                {{ __('admin.edit') }}
                            </button>

                            <button
                                type="button"
                                form="delete-role-{{ $role->id }}"
                                class="inline-flex min-h-10 items-center justify-center rounded-xl border border-rose-200 bg-rose-50 px-3 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                                onclick="document.getElementById('delete-role-{{ $role->id }}').submit()"
                            >
                                {{ __('admin.delete') }}
                            </button>
                        </div>
                    </form>

                    <form id="delete-role-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role) }}" method="post" class="hidden">
                        @csrf
                        @method('delete')
                    </form>
                </article>
            @empty
                <div class="card-surface p-6 text-center text-sm text-charcoal/60">{{ __('admin.no_data') }}</div>
            @endforelse
        </div>
    </div>
@endsection
