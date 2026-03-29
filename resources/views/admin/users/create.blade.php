@extends('layouts.admin')

@section('page-title', __('admin.add_user'))

@section('content')
    <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @include('admin.users._form')
        <button class="btn-primary mt-5">{{ __('admin.save') }}</button>
    </form>
@endsection

