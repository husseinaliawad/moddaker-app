@extends('layouts.admin')

@section('page-title', __('admin.edit_category'))

@section('content')
    <form action="{{ route('admin.categories.update', $category) }}" method="post" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.categories._form', ['category' => $category])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

