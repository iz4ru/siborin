@extends('layouts.app')

@section('title', 'Display - SIBORIN')

@section('content')
    <div id="loading" class="fixed inset-0 bg-black flex items-center justify-center text-white text-2xl z-50">
        Loading, please wait...
    </div>

    <div id="butagi-btn" class="fixed top-4 left-4 flex items-center cursor-pointer z-10">
        <!-- Lingkaran -->
        <div
            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 
             flex items-center justify-center shadow-lg transform transition duration-200 z-10
             hover:scale-110 hover:from-blue-800 hover:to-blue-600">
            <!-- Ikon Pensil -->
            <svg class="w-6 h-6" fill="white" version="1.1" id="pencil-scribble" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 250 250"
                style="enable-background:new 0 0 250 250;" xml:space="preserve">
                <g id="scribble">
                    <line class="scribble-line" x1="31" y1="222.3" x2="77.9" y2="222.3" />
                </g>
                <g id="pencil">
                    <path class="pencil-body" d="M37.6,162.2c32-32,64.4-64.2,96.3-96.3c3.9-3.9,6.6-4.3,10.9,0c13.3,13.6,26.8,27,40.3,40.4
      c1.1,1.1,2.1,2.2,2.3,3.8c0.2,1.9-0.8,3.2-2,4.5c-5.3,5.3-96.9,97.3-97.9,97.5c0-7.5,0-15,0.1-22.4c0-1.7-0.4-2.3-2.2-2.2
      c-6.7,0.1-13.4,0-20.2,0c-3,0-2.7,0.3-2.7-2.8c0-6.6,0-13.3,0-19.9c0-2.3,0-2.3-2.3-2.3C53.6,162.5,38.6,162.7,37.6,162.2z
      M76.9,159.4c2.6,0,4-1.3,5.3-2.6c19.3-19.4,38.7-38.7,58-58.1c0.7-0.7,1.4-1.3,1.8-2.1c2.1-3.5-0.2-7.9-4.2-8.3
      c-2-0.2-3.5,0.9-4.9,2.3C113.5,110,94,129.5,74.5,149c-0.6,0.6-1.3,1.2-1.7,1.9c-1.2,1.8-1.2,3.7-0.2,5.6
      C73.6,158.5,75.3,159.3,76.9,159.4z" />
                    <path class="pencil-eraser" d="M184.1,25c3.8,0,8.1,1.8,11.7,5.3c8,7.9,16,15.8,23.9,23.9c6.8,6.9,7.1,17.8,0.8,25
      c-6,6.8-12.9,12.8-19.2,19.3c-1.8,1.8-3.7,1.9-5.9,0.5c-0.7-0.5-1.3-1.1-1.9-1.7c-13.7-13.6-27.3-27.3-41-40.9
      c-3.4-3.4-3-6.2,0.1-9.2c5.1-4.8,9.8-10,15-14.7c2.2-2,4-4.2,6.7-5.5C177,25.7,179.8,25,184.1,25z" />
                    <path class="pencil-wood" d="M37.6,162.2c1.1,0.5,16,0.3,22.5,0.3c2.3,0,2.3,0,2.3,2.3c0,6.6,0,13.3,0,19.9c0,3.1-0.3,2.8,2.7,2.8
      c6.7,0,13.4,0.1,20.2,0c1.8,0,2.2,0.5,2.2,2.2c-0.1,7.5-0.1,15-0.1,22.4c-2.4,1.4-25.2,6.5-25.6,6.6c-0.2-0.8-29.3-30.5-30.6-30.6
      c0.7-5.1,2.4-10,3.5-15C35.5,169.7,37.5,162.4,37.6,162.2z" />
                    <path class="pencil-tip" d="M31.3,188.1c1.2,0.1,30.4,29.7,30.6,30.6c-8.4,2-16.8,4.1-25.3,6c-6.9,1.6-12.9-4.4-11.3-11.3
      C27.2,205,29.3,196.6,31.3,188.1z" />
                    <path class="pencil-highlight" d="M76.9,159.4c-1.6-0.1-3.3-0.8-4.3-2.9c-1-1.9-0.9-3.8,0.2-5.6c0.5-0.7,1.1-1.3,1.7-1.9
      c19.5-19.5,39-38.9,58.4-58.4c1.4-1.4,2.9-2.4,4.9-2.3c4,0.3,6.2,4.8,4.2,8.3c-0.5,0.8-1.2,1.5-1.8,2.1
      c-19.3,19.4-38.7,38.7-58,58.1C80.9,158.1,79.5,159.4,76.9,159.4z" />
                </g>
            </svg>
        </div>

        <!-- Label -->
        <span id="butagi-label"
            class="-ml-2 bg-blue-600 text-white px-3 py-1 rounded-r-lg font-semibold whitespace-nowrap 
             opacity-0 z-1 -translate-x-5 pointer-events-none transition-all duration-300">
            BUTAGI
        </span>
    </div>

    <div id="slideshow"
        class="w-full h-screen flex items-center justify-center bg-black text-white relative overflow-hidden"></div>

    <div id="bell-notification" style="display: none;"
        class="absolute inset-0 bg-white w-full flex items-center justify-center z-40">
        <div class="flex flex-col items-center" id="inner-bell">
            <svg id="bell-icon" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 !mb-5 text-yellow-400 animate-bounce"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" overflow="visible">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a2 2 0 10-4 0v1.083A6 6 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m5 4a3 3 0 01-6 0" />
            </svg>
            <p class="text-black !mt-5 text-xl">New content available!</p>
        </div>
    </div>

    <audio id="background-music" autoplay hidden></audio>
    <audio id="bell-sound" src="{{ asset('sounds/bell.mp3') }}"></audio>

    <img src="{{ asset('images/qr.jpg') }}" class="h-28 w-28 me-3 fixed left-5 bottom-5 rounded-sm" alt="QR Code" />
@endsection

@push('scripts')
    <script src="https://www.youtube.com/iframe_api"></script>
    <script>
        let items = @json($items);
        let currentIndex = 0;
        let isLoading = true;
        let mediaItems = items.filter(i => i.type !== "music");
        let musicItems = items.filter(i => i.type === "music");
        let currentMusicIndex = 0;
        let isTransitioning = false; // Flag untuk mencegah overlapping
        let currentTimer = null; // Timer untuk slide saat ini

        function preloadFiles(files, callback) {
            let loaded = 0;
            if (files.length === 0) return callback();

            files.forEach(file => {
                if (file.type === "image") {
                    let img = new Image();
                    img.src = file.src;
                    img.onload = checkDone;
                } else if (file.type === "video") {
                    checkDone();
                } else if (file.type === "music") {
                    let audio = new Audio(file.src);
                    audio.onloadeddata = checkDone;
                } else if (file.type === "text") {
                    checkDone();
                }
            });

            function checkDone() {
                loaded++;
                if (loaded === files.length) callback();
            }
        }

        function startSlideshow() {
            isLoading = false;
            document.getElementById("loading").style.display = "none";
            showItem(mediaItems[currentIndex]);
            if (musicItems.length > 0) {
                startMusicPlayer();
            }
        }

        function showItem(item, forceReplace = false) {
            // Clear timer yang sedang berjalan
            if (currentTimer) {
                clearTimeout(currentTimer);
                currentTimer = null;
            }

            // Jika sedang transisi dan bukan force replace, skip
            if (isTransitioning && !forceReplace) return;

            const slideshow = document.getElementById('slideshow');
            const current = slideshow.querySelector('.slide-wrapper');

            // Jika force replace (dari update), langsung hapus slide yang ada
            if (forceReplace && current) {
                current.remove();
                isTransitioning = false;
            }

            // Jika ada slide aktif dan bukan force replace, lakukan animasi normal
            if (current && !forceReplace) {
                isTransitioning = true;
                current.classList.remove('slide-in-right', 'fade-in');
                current.classList.add('slide-out-left');

                current.addEventListener('animationend', () => {
                    current.remove();
                    isTransitioning = false;
                    // Setelah slide lama hilang, tampilkan slide baru
                    createAndShowSlide(item);
                }, {
                    once: true
                });
            } else {
                // Tidak ada slide aktif atau force replace
                createAndShowSlide(item);
            }
        }

        function createAndShowSlide(item) {
            if (!item) return;

            const slideshow = document.getElementById('slideshow');
            const wrapper = document.createElement('div');
            wrapper.className = 'slide-wrapper slide-in-right w-full h-full';
            const playerId = 'file-' + Date.now();
            wrapper.id = playerId;

            if (item.type === "image") {
                const img = document.createElement('img');
                img.src = item.src;
                img.className = 'fullscreen-media';
                wrapper.appendChild(img);
                slideshow.appendChild(wrapper);

                currentTimer = setTimeout(nextSlide, 10000);

            } else if (item.type === "video") {
                const videoExtensions = /\.(mp4|webm|ogg|mov|mkv|avi)$/i;
                if (videoExtensions.test(item.src)) {
                    const video = document.createElement('video');
                    video.autoplay = true;
                    video.playsInline = true;
                    video.className = 'fullscreen-media';
                    video.src = item.src;

                    wrapper.appendChild(video);
                    slideshow.appendChild(wrapper);

                    video.play().catch(() => {
                        /* autoplay mungkin diblok */ });
                    video.onended = () => nextSlide();

                } else {
                    slideshow.appendChild(wrapper);

                    function createYouTubePlayer(videoId, elementId) {
                        if (typeof YT === "undefined" || typeof YT.Player === "undefined") {
                            setTimeout(() => createYouTubePlayer(videoId, elementId), 100);
                            return;
                        }

                        const player = new YT.Player(elementId, {
                            videoId: videoId,
                            playerVars: {
                                autoplay: 1,
                                controls: 0,
                                modestbranding: 1,
                                rel: 0
                            },
                            events: {
                                onReady: (e) => {
                                    e.target.mute();
                                    e.target.playVideo();
                                },
                                onStateChange: (e) => {
                                    if (e.data === YT.PlayerState.PLAYING) e.target.unMute();
                                    if (e.data === YT.PlayerState.ENDED) nextSlide();
                                }
                            }
                        });
                    }

                    createYouTubePlayer(item.src, playerId);
                }
            } else if (item.type === "text") {
                const textEl = document.createElement('div');
                textEl.textContent = item.text || "";
                textEl.className = "text-6xl md:text-8xl font-bold text-center p-6";
                wrapper.appendChild(textEl);
                slideshow.appendChild(wrapper);

                currentTimer = setTimeout(nextSlide, 10000);
            }
        }

        function nextSlide() {
            // Jangan lanjut ke slide berikutnya jika sedang transisi
            if (isTransitioning) return;

            currentIndex = (currentIndex + 1) % mediaItems.length;
            showItem(mediaItems[currentIndex]);
        }

        function startMusicPlayer() {
            const audio = document.getElementById("background-music");
            audio.src = musicItems[currentMusicIndex].src;
            audio.play();

            audio.onended = () => {
                currentMusicIndex = (currentMusicIndex + 1) % musicItems.length;
                audio.src = musicItems[currentMusicIndex].src;
                audio.play();
            };
        }

        let lastCount = null;
        let lastUpdatedAt = null;
        let firstCheckDone = false;

        async function checkForUpdates() {
            if (isLoading) return;
            try {
                const res = await fetch("{{ route('display.check') }}");
                const data = await res.json();

                if (!firstCheckDone) {
                    lastCount = data.count;
                    lastUpdatedAt = data.updated_at;
                    firstCheckDone = true;
                    return;
                }

                if (data.count !== lastCount || data.updated_at !== lastUpdatedAt) {
                    lastCount = data.count;
                    lastUpdatedAt = data.updated_at;

                    playBell();
                    await fetchData();
                }
            } catch (err) {
                console.error("Check update failed:", err);
            }
        }

        async function fetchData() {
            if (isLoading) return;

            const res = await fetch("{{ route('display.data') }}");
            items = await res.json();
            currentIndex = 0;
            mediaItems = items.filter(i => i.type !== "music");
            musicItems = items.filter(i => i.type === "music");

            // Force replace slide yang sedang aktif dengan data baru
            showItem(mediaItems[currentIndex], true);
        }

        function playBell() {
            if (isLoading) return;
            const bell = document.getElementById("bell-icon");
            const conbell = document.getElementById('bell-notification');
            bell.classList.add("animate-bell");
            conbell.style.display = "block";

            const audio = new Audio("/sounds/bell.mp3");
            audio.play();

            setTimeout(() => {
                conbell.style.display = "none";
                bell.classList.remove("animate-bell");
            }, 2000);
        }

        setInterval(checkForUpdates, 10000);
        preloadFiles(items, () => startSlideshow());

        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById("butagi-btn");
            const label = document.getElementById("butagi-label");

            btn.addEventListener("click", () => {
                if (!label.classList.contains("opacity-100")) {
                    // Klik pertama -> munculkan teks
                    label.classList.remove("opacity-0", "-translate-x-5", "pointer-events-none");
                    label.classList.add("opacity-100", "translate-x-0", "pointer-events-auto");
                } else {
                    // Klik kedua -> redirect
                    window.location.href = "https://butagi.smkn1subang.sch.id";
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        #inner-bell {
            margin-top: calc(50vh - 6rem);
        }

        .fullscreen-media {
            width: 100vw;
            height: 100vh;
            object-fit: contain;
        }

        .slide-wrapper {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutLeft {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(-100%);
                opacity: 0;
            }
        }

        .slide-in-right {
            animation: slideInRight 0.4s ease forwards;
        }

        .slide-out-left {
            animation: slideOutLeft 0.4s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease forwards;
        }
    </style>
@endpush
