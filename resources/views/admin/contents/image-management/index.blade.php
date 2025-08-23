@extends('admin.layouts.app')

@section('title', 'Image Management')

@section('content')

    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg w-full mt-14">
        <div wire:ignore.self>
            @livewire('image-table')
        </div>
    </div>

@endsection
