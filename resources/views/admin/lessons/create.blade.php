@extends('layouts.admin')

@section('page-title', __('admin.add_lesson'))

@section('content')
    <form action="{{ route('admin.lessons.store') }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @include('admin.lessons._form')
        <button class="btn-primary mt-5">{{ __('admin.save') }}</button>
    </form>
@endsection

