@extends('layouts.admin')

@section('page-title', __('admin.edit_lesson'))

@section('content')
    <form action="{{ route('admin.lessons.update', $lesson) }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.lessons._form', ['lesson' => $lesson])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

