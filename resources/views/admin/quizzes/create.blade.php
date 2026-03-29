@extends('layouts.admin')

@section('page-title', __('admin.add_quiz'))

@section('content')
    <form action="{{ route('admin.quizzes.store') }}" method="post" class="card-surface p-6">
        @csrf
        @include('admin.quizzes._form')
        <button class="btn-primary mt-5">{{ __('admin.save') }}</button>
    </form>
@endsection

