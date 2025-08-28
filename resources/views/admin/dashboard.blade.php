@extends('admin.layouts.app')

@section('title', 'Dashboard | SIBORIN')

@section('content')

    <div x-data="{
        active: localStorage.getItem('activeTab') || 'image'
    }" x-init="$watch('active', value => localStorage.setItem('activeTab', value))"
        class="p-4 border-2 border-gray-200 border-dashed rounded-lg w-full mt-14">

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

        <div class="grid grid-cols-2 gap-4 mb-4 justify-between">
            <div>
                <h1 class="text-lg font-semibold text-[#0077C3]">Welcome to Dashboard</h1>
                <p class="text-[#1A85C9]">Please select one of the following actions.</p>
            </div>

            <div class="flex items-center justify-end">
                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex gap-2 items-center"
                    type="button"> <span
                        x-text="active == 'image' ? 'Upload an image' : (active == 'video' ? 'Upload a video' : (active == 'music' ? 'Upload a music' : 'Submit a text'))"></span>
                    <i class="fa fa-chevron-down text-white" aria-hidden="true"></i>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                        <li><a href="#" @click.prevent="active='image'"
                                class="block px-4 py-2 hover:bg-gray-100">Upload an image</a></li>
                        <li><a href="#" @click.prevent="active='video'"
                                class="block px-4 py-2 hover:bg-gray-100">Upload a video</a></li>
                        <li><a href="#" @click.prevent="active='music'"
                                class="block px-4 py-2 hover:bg-gray-100">Upload a music</a></li>
                        <li><a href="#" @click.prevent="active='text'"
                                class="block px-4 py-2 hover:bg-gray-100">Submit a text</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="mt-4 mb-4 border-gray-200 rounded border-t-2">

        <div class="mx-auto">
            <h2 class="text-lg font-bold mb-4">Select the Content Type to Display</h2>
            <form method="POST" action="{{ route('dashboard.options.store') }}">
                @csrf
                <div class="mb-3">
                    <label>
                        <input type="checkbox" name="show_images" value="1" {{ $options->show_images ? 'checked' : '' }}>
                        Show Images
                    </label>
                </div>
                <div class="mb-3">
                    <label>
                        <input type="checkbox" name="show_videos" value="1" {{ $options->show_videos ? 'checked' : '' }}>
                        Show Videos
                    </label>
                </div>
                <div class="mb-3">
                    <label>
                        <input type="checkbox" name="show_musics" value="1" {{ $options->show_musics ? 'checked' : '' }}>
                        Show Musics
                    </label>
                </div>
                <button type="submit" class="mt-4 text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex gap-2 items-center">Simpan</button>
            </form>
        </div>

        <hr class="mt-4 mb-8 border-gray-200 rounded border-t-2">

        {{-- Image Upload Section --}}
        <div x-show="active === 'image'">
            <h1 class="text-lg font-semibold">
                <span>
                    <i class="fa fa-images text-gray-900" aria-hidden="true"></i>
                </span>&bull; Upload an Image
            </h1>

            <p class="text-gray-600">Upload an image to be displayed on SIBORIN.</p>

            <div class="flex mt-4 items-center justify-center w-full">
                <div class="flex flex-col items-center justify-center w-full h-auto cursor-pointer bg-gray-50">
                    <form action="{{ route('image.store') }}" enctype="multipart/form-data" name="image"
                        class="dropzone w-full h-full" id="image-dropzone">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    class="mt-4 text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex gap-2 items-center"
                    id="submit-image">
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
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-[#0077C3] focus:border-[#0077C3] block flex-1 min-w-0 w-full text-sm p-2.5 placeholder:text-gray-400 "
                                placeholder="https://yourlink.com/image.jpg">
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.25 text-center inline-flex gap-2 items-center">
                            <i class="fa fa-arrow-right text-white" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Video Upload Section --}}
        <div x-show="active === 'video'">
            <h1 class="text-lg font-semibold">
                <span>
                    <i class="fa fa-video text-gray-900" aria-hidden="true"></i>
                </span>&bull; Upload a Video
            </h1>

            <p class="text-gray-600">Upload a video to be displayed on SIBORIN.</p>

            <div class="flex mt-4 items-center justify-center w-full">
                <div class="flex flex-col items-center justify-center w-full h-auto cursor-pointer bg-gray-50">
                    <form action="{{ route('video.store') }}" enctype="multipart/form-data" name="video"
                        class="dropzone w-full h-full" id="video-dropzone">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    class="mt-4 text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex gap-2 items-center"
                    id="submit-video">
                    <span class="text-white font-semibold text-sm">
                        Submit Video</span> <i class="fa fa-cloud-upload text-white" aria-hidden="true"></i>
                </button>
            </div>

            <div class="flex items-center gap-4 my-4">
                <hr class="flex-grow border-gray-200 border-t-2 rounded-md">
                <span class="text-gray-400">or</span>
                <hr class="flex-grow border-gray-200 border-t-2 rounded-md">
            </div>

            <div class="flex flex-row justify-start">
                <form action="{{ route('video.store') }}" method="POST" class="max-w-lg w-full flex gap-2 mb-4">
                    @csrf
                    <div class="flex-1">
                        <label for="video-url" class="block mb-2 text-sm font-medium text-gray-900">Online Video URL
                            Link</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                <i class="fa fa-chain text-gray-400" aria-hidden="true"></i>
                            </span>
                            <input type="text" id="video-url" name="video_url"
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-[#0077C3] focus:border-[#0077C3] block flex-1 min-w-0 w-full text-sm p-2.5 placeholder:text-gray-400 "
                                placeholder="https://yourlink.com/video.mp4">
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.25 text-center inline-flex gap-2 items-center">
                            <i class="fa fa-arrow-right text-white" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Music Upload Section --}}
        <div x-show="active === 'music'">
            <h1 class="text-lg font-semibold">
                <span>
                    <i class="fa fa-music text-gray-900" aria-hidden="true"></i>
                </span>&bull; Upload a Music
            </h1>

            <p class="text-gray-600">Upload a music to be played on SIBORIN.</p>

            <div class="flex mt-4 items-center justify-center w-full">
                <div class="flex flex-col items-center justify-center w-full h-auto cursor-pointer bg-gray-50">
                    <form action="{{ route('music.store') }}" enctype="multipart/form-data" name="music"
                        class="dropzone w-full h-full" id="music-dropzone">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    class="mt-4 text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex gap-2 items-center"
                    id="submit-music">
                    <span class="text-white font-semibold text-sm">
                        Submit Music</span> <i class="fa fa-cloud-upload text-white" aria-hidden="true"></i>
                </button>
            </div>

            <div class="flex items-center gap-4 my-4">
                <hr class="flex-grow border-gray-200 border-t-2 rounded-md">
                <span class="text-gray-400">or</span>
                <hr class="flex-grow border-gray-200 border-t-2 rounded-md">
            </div>

            <div class="flex flex-row justify-start">
                <form action="{{ route('music.store') }}" method="POST" class="max-w-lg w-full flex gap-2 mb-4">
                    @csrf
                    <div class="flex-1">
                        <label for="music-url" class="block mb-2 text-sm font-medium text-gray-900">Online Music URL
                            Link</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                                <i class="fa fa-chain text-gray-400" aria-hidden="true"></i>
                            </span>
                            <input type="text" id="music-url" name="music_url"
                                class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-[#0077C3] focus:border-[#0077C3] block flex-1 min-w-0 w-full text-sm p-2.5 placeholder:text-gray-400 "
                                placeholder="https://yourlink.com/music.mp3">
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="text-white cursor-pointer bg-[#0077C3] hover:bg-[#1A85C9] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3.25 text-center inline-flex gap-2 items-center">
                            <i class="fa fa-arrow-right text-white" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Text Submission Section --}}
        <div x-show="active === 'text'">
            <h1 class="text-lg font-semibold">
                <span>
                    <i class="fa fa-font text-gray-900" aria-hidden="true"></i>
                </span>&bull; Submit a Text
            </h1>
            <p class="text-gray-600">Submit a text to be displayed on SIBORIN.</p>
            <form action="{{ route('text.store') }}" method="POST" class="mt-4 max-w-2xl">
                @csrf
                <div class="mb-4">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Text</label>
                    <textarea id="text" name="text" rows="4"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#0077C3] focus:border-[#0077C3] placeholder:text-gray-400"
                        placeholder="Enter your text here...">{{ old('text') }}</textarea>
                </div>
                <div class="grid grid-cols-2 items-center">
                    <p class="text-gray-500 text-sm">
                        Characters Count (<span id="charCount">0</span>/10,000)
                    </p>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="mt-2 flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-[#0077C3] rounded-lg hover:bg-[#1A85C9] focus:outline-none focus:ring-2 focus:ring-[#0077C3]">
                            <span>Submit Text</span>
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const textarea = document.getElementById("text");
        const charCount = document.getElementById("charCount");

        textarea.addEventListener("input", function() {
            charCount.textContent = this.value.length;
        });

        textarea.addEventListener("input", function() {
            if (this.value.length > 10000) {
                this.value = this.value.substring(0, 10000);
            }
            charCount.textContent = this.value.length;
        });

        Dropzone.autoDiscover = false;

        var imageDropzone = new Dropzone("#image-dropzone", {
            url: "{{ route('image.store') }}",
            paramName: "image",
            uploadMultiple: true,
            autoProcessQueue: false,
            parallelUploads: 10,
            maxFilesize: 2, // MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag and drop image(s) here or click to select files! :)",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        var videoDropzone = new Dropzone("#video-dropzone", {
            url: "{{ route('video.store') }}",
            paramName: "video",
            uploadMultiple: true,
            autoProcessQueue: false,
            parallelUploads: 10,
            maxFilesize: 2, // MB
            acceptedFiles: "video/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag and drop video(s) here or click to select files! :)",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        var musicDropzone = new Dropzone("#music-dropzone", {
            url: "{{ route('music.store') }}",
            paramName: "music",
            uploadMultiple: true,
            autoProcessQueue: false,
            parallelUploads: 10,
            maxFilesize: 2, // MB
            acceptedFiles: "audio/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag and drop song(s) here or click to select files! :)",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        document.getElementById("submit-image").addEventListener("click", function(e) {
            e.preventDefault();
            imageDropzone.processQueue();
        });

        document.getElementById("submit-video").addEventListener("click", function(e) {
            e.preventDefault();
            videoDropzone.processQueue();
        });

        document.getElementById("submit-music").addEventListener("click", function(e) {
            e.preventDefault();
            musicDropzone.processQueue();
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Styling Dropzone */
        #image-dropzone,
        #video-dropzone,
        #music-dropzone {
            border: 2px dashed #0077c3;
            border-radius: 8px;
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            transition: background-color 0.2s;
        }

        #image-dropzone:hover,
        #video-dropzone:hover,
        #music-dropzone:hover {
            background-color: #eef2ff;
        }

        #image-dropzone .dz-message,
        #video-dropzone .dz-message,
        #music-dropzone .dz-message {
            font-size: 14px;
            color: #0077c3;
            font-weight: 500
        }

        #image-dropzone .dz-preview .dz-image img,
        #video-dropzone .dz-preview .dz-image img,
        #music-dropzone .dz-preview .dz-image img {
            border-radius: 8px;
        }

        #image-dropzone .dz-preview .dz-image,
        #video-dropzone .dz-preview .dz-image,
        #music-dropzone .dz-preview .dz-image {
            width: 100px;
            height: 100px;
        }

        #image-dropzone .dz-preview,
        #video-dropzone .dz-preview,
        #music-dropzone .dz-preview {
            margin-bottom: 10px;
            background-color: unset;
        }

        #image-dropzone .dz-preview .dz-remove,
        #video-dropzone .dz-preview .dz-remove,
        #music-dropzone .dz-preview .dz-remove {
            color: #e3342f;
            cursor: pointer;
        }
    </style>
@endpush
