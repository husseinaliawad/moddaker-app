@extends('layouts.frontend')

@section('content')
    <section class="relative overflow-hidden pb-14 pt-6 sm:pt-8 lg:pb-20 lg:pt-10">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-80 bg-gradient-to-b from-primary/12 via-accent/5 to-transparent"></div>
        <div class="pointer-events-none absolute -start-20 top-12 h-56 w-56 rounded-full bg-primary/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -end-20 bottom-10 h-56 w-56 rounded-full bg-accent/15 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)]">
                <aside class="relative hidden overflow-hidden rounded-[1.75rem] border border-white/20 bg-gradient-to-br from-primary to-primaryLight p-7 text-white shadow-[0_28px_70px_-40px_rgba(10,77,64,0.95)] lg:flex lg:flex-col lg:justify-between">
                    <div class="pointer-events-none absolute inset-0 opacity-20 [background-size:16px_16px] [background-image:radial-gradient(circle_at_1px_1px,rgba(255,255,255,0.85)_1px,transparent_0)]"></div>
                    <div class="pointer-events-none absolute -bottom-16 -end-8 h-56 w-56 rounded-full bg-accent/20 blur-3xl"></div>

                    <div class="relative">
                        <span class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-3 py-1 text-xs font-semibold">
                            {{ __('auth.login') }}
                        </span>
                        <h2 class="font-display mt-4 text-4xl leading-tight">{{ __('auth.login_hook_title') }}</h2>
                        <p class="mt-3 text-sm leading-8 text-white/90">{{ __('auth.login_hook_description') }}</p>
                    </div>

                    <div class="relative mt-8 space-y-3">
                        <article class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-sm font-semibold">{{ __('auth.login_hook_point_courses') }}</p>
                        </article>
                        <article class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-sm font-semibold">{{ __('auth.login_hook_point_progress') }}</p>
                        </article>
                        <article class="rounded-xl border border-white/20 bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-sm font-semibold">{{ __('auth.login_hook_point_certificate') }}</p>
                        </article>
                    </div>
                </aside>

                <div class="rounded-[1.75rem] border border-border/80 bg-white p-6 shadow-lg sm:p-8">
                    <h1 class="font-display text-3xl text-charcoal">{{ __('auth.login') }}</h1>
                    <p class="mt-2 text-sm text-charcoal/70 sm:text-base">{{ __('auth.login_subtitle') }}</p>

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-semibold text-charcoal/85">{{ __('auth.email') }}</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-charcoal/45">
                                    <x-admin.icon name="messages" class="h-4 w-4" />
                                </span>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    autocomplete="username"
                                    class="h-12 w-full rounded-xl border border-gray-300 bg-white pe-4 ps-10 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-100"
                                    required
                                    autofocus
                                >
                            </div>
                            @error('email')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-semibold text-charcoal/85">{{ __('auth.password') }}</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3 text-charcoal/45">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.75 11.25V8.5a4.25 4.25 0 1 1 8.5 0v2.75" />
                                        <rect x="5.75" y="11.25" width="12.5" height="8.5" rx="2.25" stroke-width="1.8" />
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    autocomplete="current-password"
                                    class="h-12 w-full rounded-xl border border-gray-300 bg-white pe-4 ps-10 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-green-700 focus:outline-none focus:ring-2 focus:ring-green-100"
                                    required
                                >
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                            <label for="remember" class="inline-flex items-center gap-2.5 text-charcoal/80">
                                <input id="remember" type="checkbox" name="remember" @checked(old('remember')) class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-2 focus:ring-green-200">
                                <span>{{ __('auth.remember_me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-medium text-primary transition hover:text-primaryLight hover:underline">{{ __('auth.forgot_password') }}</a>
                            @endif
                        </div>

                        <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-xl bg-green-700 px-5 text-sm font-bold text-white transition-all duration-200 hover:-translate-y-0.5 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-200">
                            {{ __('auth.login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
