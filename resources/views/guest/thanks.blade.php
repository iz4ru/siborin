<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url={{ route('guest.form') }}">
    <title>SIBORIN | Terima Kasih</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .checkmark-animate {
            animation: checkmark 0.8s ease-out;
        }

        @keyframes countdown {
            from {
                stroke-dashoffset: 0;
            }

            to {
                stroke-dashoffset: 283;
            }
        }

        .countdown-circle {
            animation: countdown 5s linear forwards;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center fade-in">

            {{-- Success Icon --}}
            <div class="mb-6 relative inline-block">
                <div
                    class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto checkmark-animate">
                    <i class="fas fa-check text-5xl text-green-600"></i>
                </div>
                {{-- Countdown Circle --}}
                <svg class="absolute top-0 left-0 w-24 h-24 transform -rotate-90" style="margin-left: 0;">
                    <circle cx="48" cy="48" r="45" fill="none" stroke="#e5e7eb" stroke-width="6" />
                    <circle cx="48" cy="48" r="45" fill="none" stroke="#0077C3" stroke-width="6"
                        stroke-dasharray="283" stroke-dashoffset="0" class="countdown-circle" stroke-linecap="round" />
                </svg>
            </div>

            {{-- Thank You Message --}}
            <h1 class="text-3xl md:text-4xl font-bold text-[#0077C3] mb-4">
                Terima Kasih!
            </h1>

            <div class="mb-6 space-y-2">
                @if (session('guest_name'))
                    <p class="text-lg text-gray-700">
                        <span class="font-semibold">{{ session('guest_name') }}</span>
                    </p>
                @endif

                @if (session('guest_agency'))
                    <p class="text-md text-gray-600">
                        dari <span class="font-medium">{{ session('guest_agency') }}</span>
                    </p>
                @endif
            </div>

            <div class="bg-blue-50 border-l-4 border-[#0077C3] p-4 mb-6 rounded">
                <p class="text-gray-700 leading-relaxed">
                    Data Anda telah berhasil tersimpan dalam buku tamu digital kami.
                    Kami sangat menghargai kunjungan Anda.
                </p>
            </div>

            {{-- Auto Redirect Info --}}
            <div class="flex items-center justify-center gap-2 text-gray-500 text-sm">
                <i class="fas fa-info-circle"></i>
                <p>Anda akan dialihkan kembali dalam <span id="countdown" class="font-bold text-[#0077C3]">5</span>
                    detik...</p>
            </div>

            {{-- Manual Redirect Button --}}
            <div class="mt-6">
                <a href="{{ route('guest.form') }}"
                    class="inline-flex items-center gap-2 bg-[#0077C3] hover:bg-[#005a94] text-white font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-home"></i>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Countdown timer
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "{{ route('guest.form') }}";
            }
        }, 1000);
    </script>
</body>

</html>
