<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Preload & Preconnect untuk percepat load font -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Cloak -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Dropzone -->
    <!-- Dropzone CSS -->
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />

    <!-- Dropzone JS -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

</head>

<body class="bg-[#FAFAFA] overflow-x-hidden">


    <div>
        @include('admin.layouts.partials.header')
        @include('admin.layouts.partials.sidebar')
    </div>

    @yield('content')

</body>

<script>
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    togglePassword.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordInput.type = "password";
            this.classList.replace("fa-eye-slash", "fa-eye");
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const handleAlertAnimation = (alertId, duration = 2000, transitionDuration = 300) => {
            const alert = document.getElementById(alertId);
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('opacity-0');
                    alert.classList.add('opacity-100');
                }, 100);

                setTimeout(() => {
                    alert.classList.remove('opacity-100');
                    alert.classList.add('opacity-0');
                    setTimeout(() => alert.remove(),
                        transitionDuration);
                }, duration);
            }
        };

        handleAlertAnimation('errorAlert', 2000, 150);
        handleAlertAnimation('successAlert', 2000, 150);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</html>
