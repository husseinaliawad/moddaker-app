@extends('layouts.admin')

@section('page-title', __('admin.add_instructor'))

@section('content')
    <form action="{{ route('admin.instructors.store') }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @include('admin.instructors._form')
        <button class="btn-primary mt-5">{{ __('admin.save') }}</button>
    </form>
@endsection

