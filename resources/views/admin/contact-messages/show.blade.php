@extends('layouts.admin')

@section('page-title', __('admin.message_details'))

@section('content')
    <div class="card-surface p-6">
        <div class="grid gap-3 text-sm">
            <p><span class="font-bold">{{ __('student.name') }}:</span> {{ $contactMessage->name }}</p>
            <p><span class="font-bold">{{ __('contact.email') }}:</span> {{ $contactMessage->email }}</p>
            <p><span class="font-bold">{{ __('student.phone') }}:</span> {{ $contactMessage->phone ?: '-' }}</p>
            <p><span class="font-bold">{{ __('contact.subject') }}:</span> {{ $contactMessage->subject }}</p>
            <p><span class="font-bold">{{ __('contact.message') }}:</span></p>
            <div class="rounded-xl bg-cream p-4 text-charcoal/80">{{ $contactMessage->message }}</div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <form action="{{ route('admin.contact-messages.update', $contactMessage) }}" method="post">
                @csrf
                @method('patch')
                <input type="hidden" name="is_read" value="{{ $contactMessage->is_read ? 0 : 1 }}">
                <button class="btn-secondary">{{ $contactMessage->is_read ? __('admin.mark_unread') : __('admin.mark_read') }}</button>
            </form>

            <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="post">
                @csrf
                @method('delete')
                <button class="rounded-xl bg-red-100 px-4 py-2 font-semibold text-red-700">{{ __('admin.delete') }}</button>
            </form>
        </div>
    </div>
@endsection

