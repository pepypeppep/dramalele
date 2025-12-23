@extends('dramabox.layouts.master')

@section('content')
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            overscroll-behavior-y: contain;
            background: black;
        }

        .fade-out {
            opacity: 0;
            filter: blur(10px);
            transition: opacity .35s ease, filter .35s ease;
        }

        .fade-in {
            opacity: 1;
            filter: blur(0);
            transition: opacity .35s ease, filter .35s ease;
        }
    </style>

    <div class="relative h-screen w-screen bg-black overflow-hidden fade-in" id="page">

        <!-- BACK BUTTON -->
        <a href="{{ route('dramabox.show', [$id, $title]) }}"
            class="absolute top-4 left-4 z-40 bg-black/60 text-white px-3 py-1 rounded text-sm">
            ← Back
        </a>

        <!-- PROGRESS BAR -->
        <div id="progressContainer" class="absolute top-0 left-0 w-full h-1 bg-gray-700 z-40 cursor-pointer">
            <div id="progressBar" class="h-full bg-red-600 w-0"></div>
        </div>

        <!-- TIME -->
        <div id="timeIndicator" class="absolute top-2 right-3 text-xs text-white z-40 bg-black/60 px-2 py-1 rounded">
            0:00 / 0:00
        </div>

        <!-- VIDEO -->
        <div id="videoWrapper" class="absolute inset-0 transition-transform duration-300 ease-out">
            <video id="dramaVideo" src="{{ $eps->cdnList[0]->videoPathList[0]->videoPath }}"
                data-next-url="{{ route('dramabox.watch', [$id, $title, $episode + 1]) }}"
                data-prev-url="{{ route('dramabox.watch', [$id, $title, max(1, $episode - 1)]) }}"
                class="w-full h-full object-cover" autoplay playsinline></video>
        </div>

        <!-- GESTURE LAYER -->
        <div id="gestureLayer" class="absolute inset-0 z-30"></div>

        <!-- PLAY ICON -->
        <div id="playIcon"
            class="absolute inset-0 flex items-center justify-center text-6xl text-white opacity-0 transition-opacity z-40 pointer-events-none">
            ▶
        </div>

        <!-- OVERLAY TEXT -->
        <div class="absolute bottom-20 left-4 z-40 text-white">
            <h2 class="font-bold text-lg">
                Episode {{ str_replace('EP ', '', $eps->chapterName) }}
            </h2>
            <p class="text-sm text-gray-300">{{ $title }}</p>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const video = document.getElementById('dramaVideo')
            const wrapper = document.getElementById('videoWrapper')
            const playIcon = document.getElementById('playIcon')
            const gesture = document.getElementById('gestureLayer')
            const progressBar = document.getElementById('progressBar')
            const progressContainer = document.getElementById('progressContainer')
            const timeIndicator = document.getElementById('timeIndicator')
            const page = document.getElementById('page')

            let userInteracted = false
            let startY = 0
            let currentY = 0
            let startTime = 0

            const SWIPE_DISTANCE = 100
            const TAP_DISTANCE = 10
            const TAP_TIME = 250

            // =====================
            // FORMAT TIME
            // =====================
            const formatTime = (sec) => {
                if (!sec || isNaN(sec)) return '0:00'
                const m = Math.floor(sec / 60)
                const s = Math.floor(sec % 60).toString().padStart(2, '0')
                return `${m}:${s}`
            }

            // =====================
            // TAP PROGRESS → SEEK
            // =====================
            progressContainer.addEventListener('click', (e) => {
                const rect = progressContainer.getBoundingClientRect()
                const percent = (e.clientX - rect.left) / rect.width
                video.currentTime = percent * video.duration
            })

            // =====================
            // VIDEO TIMELINE
            // =====================
            video.addEventListener('loadedmetadata', () => {
                timeIndicator.textContent = `0:00 / ${formatTime(video.duration)}`
            })

            video.addEventListener('timeupdate', () => {
                if (!video.duration) return
                const percent = (video.currentTime / video.duration) * 100
                progressBar.style.width = percent + '%'
                timeIndicator.textContent =
                    `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`
            })

            // =====================
            // AUTO NEXT + FADE
            // =====================
            const goNext = (url) => {
                page.classList.add('fade-out')
                setTimeout(() => window.location.href = url, 300)
            }

            video.addEventListener('ended', () => {
                goNext(video.dataset.nextUrl)
            })

            // =====================
            // TOUCH START
            // =====================
            gesture.addEventListener('touchstart', (e) => {
                startY = e.touches[0].clientY
                currentY = 0
                startTime = Date.now()
                wrapper.style.transition = 'none'
            }, {
                passive: true
            })

            // =====================
            // TOUCH MOVE (PREVIEW)
            // =====================
            gesture.addEventListener('touchmove', (e) => {
                currentY = e.touches[0].clientY - startY
                const drag = Math.max(Math.min(currentY, 150), -150)
                wrapper.style.transform = `translateY(${drag}px)`
                e.preventDefault()
            }, {
                passive: false
            })

            // =====================
            // TOUCH END
            // =====================
            gesture.addEventListener('touchend', () => {
                const duration = Date.now() - startTime
                const absMove = Math.abs(currentY)

                wrapper.style.transition = 'transform .3s ease-out'

                // TAP
                if (absMove < TAP_DISTANCE && duration < TAP_TIME) {
                    if (!userInteracted) {
                        video.muted = false
                        video.volume = 1
                        userInteracted = true
                    }
                    video.paused ? video.play() : video.pause()
                    wrapper.style.transform = 'translateY(0)'
                    return
                }

                // SWIPE
                if (absMove > SWIPE_DISTANCE) {
                    if (currentY < 0) {
                        wrapper.style.transform = 'translateY(-100%)'
                        goNext(video.dataset.nextUrl)
                    } else {
                        wrapper.style.transform = 'translateY(100%)'
                        goNext(video.dataset.prevUrl)
                    }
                } else {
                    wrapper.style.transform = 'translateY(0)'
                }
            })

            // =====================
            // PLAY ICON STATE
            // =====================
            video.addEventListener('play', () => {
                playIcon.classList.remove('opacity-80')
                playIcon.classList.add('opacity-0')
            })

            video.addEventListener('pause', () => {
                playIcon.classList.remove('opacity-0')
                playIcon.classList.add('opacity-80')
            })

        })
    </script>
@endsection
