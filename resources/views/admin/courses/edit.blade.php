@extends('layouts.admin')

@section('page-title', __('admin.edit_course'))

@section('content')
    <form action="{{ route('admin.courses.update', $course) }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.courses._form', ['course' => $course])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

