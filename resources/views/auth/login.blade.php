@extends('layouts.app')

@section('title', 'Login | SIBORIN')

<body class="bg-gradient-to-b from-[#FAFAFA] from-50% to-[#ECECEC] overflow-x-hidden">
    <div class="flex-1 flex flex-col">
        <div class="p-6">
            <div class="flex items-center gap-6 px-8 py-4">
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center transform px-4 py-8">
            <div class="w-full max-w-sm">
                <div class="flex flex-col -translate-y-4 items-center justify-center gap-8">
                    <div class="flex items-center justify-center -translate-y-5">
                        <img src="{{ asset('images/siborin-full.png') }}" alt="Logo SIBORIN"
                            class="max-w-[250px] lg:max-w-2xs">
                    </div>
                    <div class="bg-white/30 backdrop-blur-lg rounded-xl shadow-lg p-8 w-full">
                        <div class="flex flex-col items-center justify-center gap-2 mb-6">
                            <p class="text-gray-700 text-center font-bold text-3xl">Selamat Datang!</p>
                            <p class="text-gray-500 text-center">Masuk ke akun <span class="font-bold">SIBORIN</span>
                                Anda</p>
                        </div>

                        <!-- Login Form -->
                        <div class="">
                            <form action="{{ route('login.post') }}" method="POST" onsubmit="validateForm(event)">
                                @csrf
                                <div class="space-y-4">
                                    <div class="relative w-full">
                                        <i
                                            class="fa fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Email" type="email" name="email" id="email"
                                            value="{{ old('email') }}"
                                            class="text-sm w-full h-14 pl-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0077C3] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autofocus autocomplete="email">
                                    </div>
                                    <div class="relative w-full">
                                        <i
                                            class="fa fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                                        <input placeholder="Masukkan Password" type="password" name="password"
                                            id="password"
                                            class="text-sm w-full h-14 pl-12 pr-12 placeholder:text-gray-300 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0077C3] transition duration-300 ease-in-out rounded-md shadow-sm"
                                            required autocomplete="off">
                                        <i class="fa fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 cursor-pointer"
                                            id="togglePassword"></i>
                                    </div>

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible relative text-sm py-2 px-4 bg-green-100 text-green-500 border border-green-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                                            role="alert" id="successAlert">
                                            <i class="fa fa-circle-check absolute left-4 top-1/2 -translate-y-1/2"></i>
                                            <p class="ml-6">{{ session('success') }}</p>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible relative text-sm py-2 px-4 bg-red-100 text-red-500 border border-red-500 rounded-md opacity-0 transition-opacity duration-150 ease-in-out"
                                            role="alert" id="errorAlert">
                                            <i
                                                class="fa fa-circle-exclamation absolute left-4 top-1/2 -translate-y-1/2"></i>
                                            <ul class="list-none m-0 p-0">
                                                @foreach ($errors->all() as $error)
                                                    <li class="ml-6">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <!-- Login Buttons -->
                                <div class="space-y-4 mt-4">
                                    <button type="submit"
                                        class="cursor-pointer flex items-center justify-center w-full px-6 py-4 bg-gradient-to-r from-[#0077C3] to-[#1A85C9] text-[#FAFAFA] hover:bg-gradient-r hover:from-[#006BB0] hover:to-[#005F9C] rounded-lg transition-colors">
                                        <div class="text-center flex items-center gap-2">
                                            <span class="font-bold">Login</span>
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <footer>
                        <p class="text-gray-500 text-sm"><span class="font-bold">© {{ date('Y') }} SIBORIN
                                &bull;</span> All rights reserved.</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</body>
