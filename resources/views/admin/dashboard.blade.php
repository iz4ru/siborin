@extends('admin.layouts.app')

@section('title', 'Dashboard - SIBORIN')

@section('content')

    <div class="p-4 sm:ml-64">
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
                <h1 class="text-lg font-semibold text-[#0077C3]">Welcome to Dashboard</h1>
                <p class="text-[#1A85C9]">Please select the action to be taken below.</p>
            </div>

            <hr class="my-4 border-gray-200 rounded border-t-2">

            <div>
                <h1 class="text-lg font-semibold">
                    <span>
                        <i class="fa fa-images text-gray-900" aria-hidden="true"></i>
                    </span>&bull; Upload an Image
                </h1>

                <p class="text-gray-600">Upload an image to be displayed in SIBORIN.</p>

                <div class="flex mt-4 items-center justify-center w-full">
                    <div class="flex flex-col items-center justify-center w-full h-auto cursor-pointer bg-gray-50">
                        <form action="{{ route('image.store') }}" enctype="multipart/form-data" name="image"
                            class="dropzone w-full h-full" id="image-dropzone">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="space-x-1 mt-4 cursor-pointer bg-[#0077C3] px-4 py-2 rounded-md" id="submit-image">
                        <span class="text-white font-semibold text-sm">
                            Submit Image</span> <i class="fa fa-cloud-upload text-white" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="flex items-center gap-4 my-4">
                    <hr class="flex-grow border-gray-200 border-t-2 rounded-md">
                    <span class="text-gray-400">or</span>
                    <hr class="flex-grow border-gray-200 border-t-2 rounded-md">
                </div>

                <div class="flex flex-row justify-start">
                    <form action="{{ route('image.store') }}" method="POST" class="max-w-lg w-full flex gap-2 mb-4">
                        @csrf
                        <div class="flex-1">
                            <label for="image-url" class="block mb-2 text-sm font-medium text-gray-900">Online Image URL
                                Link</label>
                            <div class="flex">
                                <span
                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                    <i class="fa fa-chain text-gray-400" aria-hidden="true"></i>
                                </span>
                                <input type="text" id="image-url" name="image_url"
                                    class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 placeholder:text-gray-400 "
                                    placeholder="https://yourlink.com/image.jpg">
                            </div>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="mt-6 cursor-pointer bg-[#0077C3] px-4 py-2 rounded-md">
                                <i class="fa fa-arrow-right text-white" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#image-dropzone", {
            url: "{{ route('image.store') }}",
            paramName: "image",
            uploadMultiple: true,
            autoProcessQueue: false,
            parallelUploads: 10,
            maxFilesize: 2,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag and drop images here or click to select files! :)",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        document.getElementById("submit-image").addEventListener("click", function(e) {
            e.preventDefault();
            myDropzone.processQueue();
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Styling Dropzone */
        #image-dropzone {
            border: 2px dashed #0077c3;
            border-radius: 8px;
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            transition: background-color 0.2s;
        }

        #image-dropzone:hover {
            background-color: #eef2ff;
        }

        #image-dropzone .dz-message {
            font-size: 14px;
            color: #0077c3;
            font-weight: 500
        }

        #image-dropzone .dz-preview .dz-image img {
            border-radius: 8px;
        }

        #image-dropzone .dz-preview .dz-image {
            width: 100px;
            height: 100px;
        }

        #image-dropzone .dz-preview {
            margin-bottom: 10px;
            background-color: unset;
        }

        #image-dropzone .dz-preview .dz-remove {
            color: #e3342f;
            cursor: pointer;
        }
    </style>
@endpush
