@extends('admin.layouts.app')

@section('title', $text->title . ' | Text Details')

@section('content')
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg w-full mt-14">

        {{-- Alert Section --}}
        <div class="w-full space-y-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible relative mb-4 w-full text-sm py-2 px-4 bg-green-100 text-green-500 border border-green-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                    role="alert" id="successAlert">
                    <i class="fa fa-circle-check absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <p class="ml-6">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible relative mb-4 w-full text-sm py-2 px-4 bg-red-100 text-red-500 border border-red-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                    role="alert" id="errorAlert">
                    <i class="fa fa-circle-exclamation absolute left-4 top-1/2 -translate-y-1/2"></i>
                    <ul class="list-none m-0 p-0">
                        @foreach ($errors->all() as $error)
                            <li class="ml-6">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div>
            <h1 class="text-lg font-semibold text-[#0077C3]">Text Details</h1>
            <p class="text-[#1A85C9]">See the text details.</p>
        </div>
        <hr class="mt-4 mb-8 border-gray-200 rounded border-t-2">

        <div class="mb-6">
            <a href="{{ route('text.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-[#0077C3] rounded-lg hover:bg-[#1A85C9] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0077C3] transition">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                <span>Back</span>
            </a>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-semibold">Title:</h2>
            <p class="text-gray-700">{{ $text->title }}</p>
        </div>
        <div class="mb-4 p-4 border-2 border-gray-200 border-dashed rounded-lg w-full">
            <h2 class="text-xl font-semibold">Text:</h2>
            <p class="text-gray-700 text-base/7 whitespace-pre-line">{{ $text->text }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Author:</h2>
            <p class="text-gray-700">{{ $text->user->name }}</p>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Uploaded At:</h2>
            <div class="flex flex-row items-center gap-2">
                <span class="text-gray-700">{{ $text->created_at->format('d M Y H:i') }} </span>
                <span class="text-gray-300">|</span>
                <span class="text-[#0077C3]">{{ $text->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>

@endsection
