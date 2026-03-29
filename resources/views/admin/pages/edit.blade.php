@extends('layouts.admin')

@section('page-title', __('admin.edit_page'))

@section('content')
    <form action="{{ route('admin.pages.update', $page) }}" method="post" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.pages._form', ['page' => $page])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

