@props(['name', 'class' => 'h-5 w-5'])

@switch($name)
    @case('dashboard')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.75 5.75h6.5v5.5h-6.5zm8 0h6.5v9h-6.5zm-8 7h6.5v5.5h-6.5zm8 2.5h6.5v3h-6.5z"/>
        </svg>
        @break

    @case('users')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.25v-.5a3.75 3.75 0 0 0-3.75-3.75h-2.5A3.75 3.75 0 0 0 5 18.75v.5m12-9.5a2.75 2.75 0 1 0 0-5.5 2.75 2.75 0 0 0 0 5.5Zm-7 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm8.5 8.5v-.5A3.25 3.25 0 0 0 16 14.9"/>
        </svg>
        @break

    @case('shield')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3.75 5.5 6.5v4.75c0 4.08 2.62 7.82 6.5 9 3.88-1.18 6.5-4.92 6.5-9V6.5L12 3.75Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9.5 12 1.75 1.75L14.75 10"/>
        </svg>
        @break

    @case('categories')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 5h6v6H5zm8 0h6v6h-6zM5 13h6v6H5zm8 2h6m-6 4h6"/>
        </svg>
        @break

    @case('courses')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 4.75h9.5A2.75 2.75 0 0 1 18.25 7.5v11.75H8.5A2.75 2.75 0 0 0 5.75 22V5A.25.25 0 0 1 6 4.75Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.75 8.5h6.5m-6.5 3.5h6.5m-6.5 3.5h4"/>
        </svg>
        @break

    @case('lessons')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 5.75h10A2.25 2.25 0 0 1 19.25 8v8A2.25 2.25 0 0 1 17 18.25H7A2.25 2.25 0 0 1 4.75 16V8A2.25 2.25 0 0 1 7 5.75Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m10 9 5 3-5 3V9Z"/>
        </svg>
        @break

    @case('instructors')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5 4.75 8.5 12 12l7.25-3.5L12 5Zm-5.5 6.5V15c0 1.93 2.46 3.5 5.5 3.5s5.5-1.57 5.5-3.5v-3.5"/>
        </svg>
        @break

    @case('enrollments')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.75 7.5A2.75 2.75 0 0 1 8.5 4.75h9.75v10.75A2.75 2.75 0 0 1 15.5 18.25H5.75V7.5Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 11 2 2 4-4"/>
        </svg>
        @break

    @case('certificates')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.75 14.13 7l2.94.42-1.4 2.72.33 3.11L12 11.92 9 13.25l.33-3.11-1.4-2.72L10.87 7 12 4.75ZM8.25 14.5v4.75l3.75-2 3.75 2V14.5"/>
        </svg>
        @break

    @case('quizzes')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4.75h8A2.25 2.25 0 0 1 18.25 7v12A2.25 2.25 0 0 1 16 21.25H8A2.25 2.25 0 0 1 5.75 19V7A2.25 2.25 0 0 1 8 4.75Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 9.5h6m-6 4h3m4-7v2"/>
        </svg>
        @break

    @case('pages')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.75 4.75h6.69l3.81 3.81V18A2.25 2.25 0 0 1 16 20.25H7.75A2.25 2.25 0 0 1 5.5 18V7A2.25 2.25 0 0 1 7.75 4.75Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.5 4.75V9h4.25M8.75 12.25h6.5m-6.5 3.5h6.5"/>
        </svg>
        @break

    @case('settings')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.25 4.75h1.5l.67 2.04a6.77 6.77 0 0 1 1.45.6l1.92-.92 1.06 1.06-.92 1.92c.24.46.44.95.6 1.45l2.04.67v1.5l-2.04.67c-.16.5-.36.99-.6 1.45l.92 1.92-1.06 1.06-1.92-.92c-.46.24-.95.44-1.45.6l-.67 2.04h-1.5l-.67-2.04a6.77 6.77 0 0 1-1.45-.6l-1.92.92-1.06-1.06.92-1.92a6.77 6.77 0 0 1-.6-1.45l-2.04-.67v-1.5l2.04-.67c.16-.5.36-.99.6-1.45l-.92-1.92 1.06-1.06 1.92.92c.46-.24.95-.44 1.45-.6l.67-2.04Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15.25A3.25 3.25 0 1 0 12 8.75a3.25 3.25 0 0 0 0 6.5Z"/>
        </svg>
        @break

    @case('messages')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.75 7.25A2.5 2.5 0 0 1 8.25 4.75h7.5a2.5 2.5 0 0 1 2.5 2.5v9.5a2.5 2.5 0 0 1-2.5 2.5h-7.5a2.5 2.5 0 0 1-2.5-2.5v-9.5Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6.5 7 5.5 4 5.5-4"/>
        </svg>
        @break

    @case('search')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.75 17a6.25 6.25 0 1 0 0-12.5 6.25 6.25 0 0 0 0 12.5Zm8 2-3.4-3.4"/>
        </svg>
        @break

    @case('bell')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5.25a4.25 4.25 0 0 0-4.25 4.25v2.04c0 .65-.17 1.29-.5 1.85l-1 1.71a1 1 0 0 0 .86 1.5h9.78a1 1 0 0 0 .86-1.5l-1-1.7a3.74 3.74 0 0 1-.5-1.86V9.5A4.25 4.25 0 0 0 12 5.25Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 18.75a2 2 0 0 0 4 0"/>
        </svg>
        @break

    @case('home')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m4.75 10.25 7.25-5.5 7.25 5.5V19a1.25 1.25 0 0 1-1.25 1.25H6A1.25 1.25 0 0 1 4.75 19v-8.75Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.25 20.25v-5.5h5.5v5.5"/>
        </svg>
        @break

    @case('menu')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 7.5h14M5 12h14M5 16.5h10"/>
        </svg>
        @break

    @case('close')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m7 7 10 10M17 7 7 17"/>
        </svg>
        @break

    @case('plus')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v14m7-7H5"/>
        </svg>
        @break

    @case('chart')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.75 18.25h12.5M7.75 16v-4m4 4V7.75m4 8.25v-6"/>
        </svg>
        @break

    @case('spark')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3.75 1.9 4.35 4.35 1.9-4.35 1.9L12 16.25l-1.9-4.35-4.35-1.9 4.35-1.9L12 3.75Zm6 11 1 2.25 2.25 1L19 19l-1 2.25L17 19l-2.25-1 2.25-1L18 14.75Z"/>
        </svg>
        @break

    @case('trend-up')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5.75 15.75 5-5 3.5 3.5 4-4"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.75 6.75h3.5v3.5"/>
        </svg>
        @break

    @case('trend-down')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5.75 8.25 5 5 3.5-3.5 4 4"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.75 17.25h3.5v-3.5"/>
        </svg>
        @break

    @case('trend-flat')
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 12h12"/>
        </svg>
        @break

    @default
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" {{ $attributes->merge(['class' => $class]) }}>
            <circle cx="12" cy="12" r="7.25" stroke-width="1.8"/>
        </svg>
@endswitch
