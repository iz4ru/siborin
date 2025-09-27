@extends('layouts.app')

@section('title', 'Display - SIBORIN')

@section('content')
<div id="loading" class="fixed inset-0 bg-black flex items-center justify-center text-white text-2xl z-50">
    Loading, please wait...
</div>

<div id="slideshow" class="w-full h-screen flex items-center justify-center bg-black text-white relative overflow-hidden"></div>

<div id="bell-notification" style="display: none;" class="absolute inset-0 bg-white w-full flex items-center justify-center z-40">
    <div class="flex flex-col items-center" id="inner-bell">
        <svg id="bell-icon" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 !mb-5 text-yellow-400 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" overflow="visible">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a2 2 0 10-4 0v1.083A6 6 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m5 4a3 3 0 01-6 0" />
        </svg>
        <p class="text-black !mt-5 text-xl">New content available!</p>
    </div>
</div>

<audio id="background-music" autoplay hidden></audio>
<audio id="bell-sound" src="{{ asset('sounds/bell.mp3') }}"></audio>
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
        }, { once: true });
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

            video.play().catch(() => { /* autoplay mungkin diblok */ });
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
                    playerVars: { autoplay: 1, controls: 0, modestbranding: 1, rel: 0 },
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
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0);    opacity: 1; }
    }
    @keyframes slideOutLeft {
        from { transform: translateX(0);    opacity: 1; }
        to   { transform: translateX(-100%);opacity: 0; }
    }

    .slide-in-right { animation: slideInRight 0.4s ease forwards; }
    .slide-out-left { animation: slideOutLeft 0.4s ease forwards; }

    @keyframes fadeIn { from {opacity:0} to {opacity:1} }
    .fade-in { animation: fadeIn 0.3s ease forwards; }
</style>
@endpush
