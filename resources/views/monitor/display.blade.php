@extends('layouts.app')

@section('title', 'Display - SIBORIN')

@section('content')
<div id="loading" class="fixed inset-0 bg-black flex items-center justify-center text-black text-2xl z-50">
    Loading, please wait...
</div>

<div id="slideshow" class="w-full h-screen flex items-center justify-center bg-black text-white relative"></div>

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
<script>
    let items = @json($items);
    let currentIndex = 0;
    let isLoading = true;
    let mediaItems = items.filter(i => i.type !== "music");
    let musicItems = items.filter(i => i.type === "music");
    let currentMusicIndex = 0;

    function preloadFiles(files, callback) {
        let loaded = 0;
        if (files.length === 0) return callback();

        files.forEach(file => {
            if (file.type === "image") {
                let img = new Image();
                img.src = file.src;
                img.onload = checkDone;
            } else if (file.type === "video") {
                let video = document.createElement("video");
                video.src = file.src;
                video.onloadeddata = checkDone;
            } else if (file.type === "music") {
                let audio = new Audio(file.src);
                audio.onloadeddata = checkDone;
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

    function showItem(item) {
        const slideshow = document.getElementById('slideshow');
        slideshow.innerHTML = "";

        if (!item) return;

        if (item.type === "image") {
            let img = document.createElement("img");
            img.src = item.src;
            img.className = "w-full h-full object-contain";
            slideshow.appendChild(img);
            setTimeout(nextSlide, 7000);

        } else if (item.type === "video") {
            let video = document.createElement("video");
            video.src = item.src;
            video.autoplay = true;
            video.className = "w-full h-full object-contain";
            slideshow.appendChild(video);
            video.onended = () => nextSlide();

        }
    }

    function nextSlide() {
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
                // simpan baseline, jangan trigger bel
                lastCount = data.count;
                lastUpdatedAt = data.updated_at;
                firstCheckDone = true;
                return;
            }

            // kalau ada perubahan jumlah atau updated_at
            if (data.count !== lastCount || data.updated_at !== lastUpdatedAt) {
                lastCount = data.count;
                lastUpdatedAt = data.updated_at;

                playBell();

                // refetch data terbaru
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
        showItem(mediaItems[currentIndex]);
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
    </style>
@endpush