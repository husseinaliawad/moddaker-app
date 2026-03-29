@extends('layouts.admin')

@section('page-title', __('admin.edit_quiz'))

@section('content')
    <form action="{{ route('admin.quizzes.update', $quiz) }}" method="post" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.quizzes._form', ['quiz' => $quiz])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

