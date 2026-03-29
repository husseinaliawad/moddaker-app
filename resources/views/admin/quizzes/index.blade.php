@extends('layouts.admin')

@section('page-title', __('admin.quizzes'))

@section('content')
    <div class="card-surface p-5">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">{{ __('admin.quizzes') }}</h2>
            <a href="{{ route('admin.quizzes.create') }}" class="btn-primary text-sm">{{ __('admin.add_quiz') }}</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-border text-start text-charcoal/60">
                        <th class="px-3 py-2">#</th>
                        <th class="px-3 py-2">{{ __('admin.title') }}</th>
                        <th class="px-3 py-2">{{ __('admin.course') }}</th>
                        <th class="px-3 py-2">{{ __('admin.passing_score') }}</th>
                        <th class="px-3 py-2">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr class="border-b border-border/70">
                            <td class="px-3 py-2">{{ $quiz->id }}</td>
                            <td class="px-3 py-2">{{ $quiz->title }}</td>
                            <td class="px-3 py-2">{{ $quiz->course?->title ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $quiz->passing_score }}%</td>
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="rounded-lg bg-primary/10 px-2 py-1 text-primary">{{ __('admin.edit') }}</a>
                                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="post">
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
        <div class="mt-4">{{ $quizzes->links() }}</div>
    </div>
@endsection

