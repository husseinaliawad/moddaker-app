@extends('layouts.admin')

@section('page-title', __('admin.add_page'))

@section('content')
    <form action="{{ route('admin.pages.store') }}" method="post" class="card-surface p-6">
        @csrf
        @include('admin.pages._form')
        <button class="btn-primary mt-5">{{ __('admin.save') }}</button>
    </form>
@endsection

