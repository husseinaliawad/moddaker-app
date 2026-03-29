@extends('layouts.admin')

@section('page-title', __('admin.add_category'))

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="post" class="card-surface p-6">
        @csrf
        @include('admin.categories._form')
        <button class="btn-primary mt-5">{{ __('admin.save') }}</button>
    </form>
@endsection

