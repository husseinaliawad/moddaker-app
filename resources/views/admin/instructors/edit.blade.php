@extends('layouts.admin')

@section('page-title', __('admin.edit_instructor'))

@section('content')
    <form action="{{ route('admin.instructors.update', $instructor) }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.instructors._form', ['instructor' => $instructor])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

