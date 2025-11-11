<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIBORIN | Buku Tamu Digital</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-4xl">

        {{-- Alert Section --}}
        <div class="w-full space-y-3 mb-6">
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

        {{-- Main Card --}}
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg w-full bg-white">

            <div>
                <h1 class="text-lg font-semibold text-[#0077C3]">Buku Tamu Digital</h1>
                <p class="text-[#1A85C9]">Silakan ambil foto dan isi data tamu Anda.</p>
            </div>
            <hr class="mt-4 mb-8 border-gray-200 rounded border-t-2">

            {{-- Step 1: Camera Section --}}
            <div id="cameraSection">
                <h2 class="text-md font-semibold text-[#0077C3] mb-4">Langkah 1: Ambil Foto</h2>

                <div class="space-y-4">
                    {{-- Video Preview --}}
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="aspect-ratio: 4/3;">
                        <video id="video" autoplay playsinline class="w-full h-full object-cover"></video>
                        <div id="cameraLoading"
                            class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75">
                            <div class="text-center text-white">
                                <i class="fas fa-spinner fa-spin text-4xl mb-2"></i>
                                <p>Mengaktifkan kamera...</p>
                            </div>
                        </div>
                    </div>

                    {{-- Canvas (Hidden) --}}
                    <canvas id="canvas" class="hidden"></canvas>

                    {{-- Photo Preview --}}
                    <div id="photoPreview" class="hidden">
                        <div class="relative bg-gray-900 rounded-lg overflow-hidden" style="aspect-ratio: 4/3;">
                            <img id="photo" class="w-full h-full object-cover">
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-3">
                        <button type="button" id="captureBtn"
                            class="flex-1 bg-[#0077C3] hover:bg-[#005a94] text-white font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out flex items-center justify-center gap-2">
                            <i class="fas fa-camera"></i>
                            <span>Ambil Gambar</span>
                        </button>

                        <button type="button" id="retakeBtn"
                            class="hidden flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out flex items-center justify-center gap-2">
                            <i class="fas fa-redo"></i>
                            <span>Ambil Ulang</span>
                        </button>

                        <button type="button" id="continueBtn"
                            class="hidden flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-right"></i>
                            <span>Lanjutkan Isi Form Tamu</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Step 2: Form Section --}}
            <div id="formSection" class="hidden">
                <h2 class="text-md font-semibold text-[#0077C3] mb-4">Langkah 2: Isi Data Tamu</h2>

                <form action="{{ route('guest.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Hidden Photo Input --}}
                    <input type="hidden" name="photo_data" id="photoData">

                    {{-- Photo Preview in Form --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Tamu</label>
                        <div class="relative bg-gray-900 rounded-lg overflow-hidden w-[400px] h-[300px] mx-auto" style="aspect-ratio: 4/3;">
                            <img id="formPhoto" class="w-full h-full object-cover">
                        </div>
                    </div>

                    {{-- Name Input --}}
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0077C3] focus:border-transparent transition duration-150 ease-in-out"
                            placeholder="Masukkan nama lengkap Anda">
                    </div>

                    {{-- Agency Input --}}
                    <div class="mb-6">
                        <label for="agency" class="block text-sm font-medium text-gray-700 mb-2">
                            Asal Instansi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="agency" name="agency" required value="{{ old('agency') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0077C3] focus:border-transparent transition duration-150 ease-in-out"
                            placeholder="Masukkan asal instansi Anda">
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex gap-3">
                        <button type="button" id="backBtn"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </button>

                        <button type="submit"
                            class="flex-1 bg-[#0077C3] hover:bg-[#005a94] text-white font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Simpan Data Tamu</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        // Elements
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photo = document.getElementById('photo');
        const photoPreview = document.getElementById('photoPreview');
        const cameraLoading = document.getElementById('cameraLoading');

        const captureBtn = document.getElementById('captureBtn');
        const retakeBtn = document.getElementById('retakeBtn');
        const continueBtn = document.getElementById('continueBtn');
        const backBtn = document.getElementById('backBtn');

        const cameraSection = document.getElementById('cameraSection');
        const formSection = document.getElementById('formSection');

        const photoData = document.getElementById('photoData');
        const formPhoto = document.getElementById('formPhoto');

        let stream = null;

        // Initialize Camera
        async function initCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 960
                        }
                    }
                });
                video.srcObject = stream;
                cameraLoading.classList.add('hidden');
            } catch (err) {
                console.error('Error accessing camera:', err);
                cameraLoading.innerHTML = `
                    <div class="text-center text-white">
                        <i class="fas fa-exclamation-triangle text-4xl mb-2"></i>
                        <p>Gagal mengakses kamera. Pastikan izin kamera sudah diberikan.</p>
                    </div>
                `;
            }
        }

        // Capture Photo
        captureBtn.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            const imageData = canvas.toDataURL('image/jpeg', 0.9);
            photo.src = imageData;

            // Hide video, show preview
            video.parentElement.classList.add('hidden');
            photoPreview.classList.remove('hidden');

            // Update buttons
            captureBtn.classList.add('hidden');
            retakeBtn.classList.remove('hidden');
            continueBtn.classList.remove('hidden');
        });

        // Retake Photo
        retakeBtn.addEventListener('click', () => {
            video.parentElement.classList.remove('hidden');
            photoPreview.classList.add('hidden');

            captureBtn.classList.remove('hidden');
            retakeBtn.classList.add('hidden');
            continueBtn.classList.add('hidden');
        });

        // Continue to Form
        continueBtn.addEventListener('click', () => {
            const imageData = canvas.toDataURL('image/jpeg', 0.9);
            photoData.value = imageData;
            formPhoto.src = imageData;

            // Stop camera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }

            // Switch sections
            cameraSection.classList.add('hidden');
            formSection.classList.remove('hidden');
        });

        // Back to Camera
        backBtn.addEventListener('click', () => {
            formSection.classList.add('hidden');
            cameraSection.classList.remove('hidden');

            // Restart camera
            initCamera();
        });

        // Alert auto-hide
        setTimeout(() => {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');

            if (successAlert) {
                successAlert.style.opacity = '1';
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 150);
                }, 3000);
            }

            if (errorAlert) {
                errorAlert.style.opacity = '1';
                setTimeout(() => {
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 150);
                }, 5000);
            }
        }, 100);

        // Initialize on page load
        initCamera();
    </script>
</body>

</html>
