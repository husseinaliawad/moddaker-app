@extends('layouts.admin')

@section('page-title', __('admin.edit_user'))

@section('content')
    <form action="{{ route('admin.users.update', $user) }}" method="post" enctype="multipart/form-data" class="card-surface p-6">
        @csrf
        @method('patch')
        @include('admin.users._form', ['user' => $user])
        <button class="btn-primary mt-5">{{ __('admin.update') }}</button>
    </form>
@endsection

