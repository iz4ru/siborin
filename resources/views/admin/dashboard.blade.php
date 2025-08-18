@extends('admin.layouts.app')

@section('title', 'Dashboard - SIBORIN')

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

        <ul>
            <li>
                <h1 class="text-lg font-semibold">&bull; Upload an Image</h1>
                <p class="text-gray-600">Upload an image to be displayed in SIBORIN.</p>
                <div class="flex mt-4 items-center justify-center w-full">
                    <div
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                        <form action="#" class="dropzone" id="image-dropzone">
                            @csrf
                            <input id="dropzone-file" type="file" name="images[]" class="hidden" />
                        </form>
                    </div>
                </div>
            </li>

            <hr class="my-4 border-gray-200 rounded border-t-2">

            <li>
                <h1 class="text-lg font-semibold">&bull; Upload a Video</h1>
            </li>
            <li></li>
        </ul>

    </div>
</div>

<script>
    Dropzone.options.imageDropzone = {
        url: "",
        maxFilesize: 2, // MB
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
        addRemoveLinks: true,
        dictDefaultMessage: "Drag and drop an image here or click to upload",
        init: function() {
            this.on("success", function(file, response) {
                if (response.success) {
                    // Handle success response
                    console.log("Image uploaded successfully:", response);
                } else {
                    // Handle error response
                    console.error("Error uploading image:", response.message);
                }
            });
            this.on("error", function(file, errorMessage) {
                console.error("Error uploading file:", errorMessage);
            });
        }
    };
</script>
