@extends('master')

@php
    $cover = str_replace('@w=100&h=135', '', $chapterlist[$episode - 1]->cover);
@endphp
@section('content')
    <main class="Video_videoWrap__HUe7w">
        <div class="Video_videoHeader__rB_Ky">
            <div class="breadcrumb_crumbsWrap__SWofi">
                <div class="breadcrumb_crumbItem__gzO8K">
                    <a href="/">Home</a>
                    <img alt=">" width="24" height="24" decoding="async" data-nimg="1"
                        class="breadcrumb_crumbIcon__F6TLQ" style="color:transparent"
                        src="{{ asset('images/arrow-left.png') }}">
                </div>

                <div class="breadcrumb_crumbItem__gzO8K">
                    <a href="drama?id=41000105764&lang=en">{{ $data->bookName }}</a><img alt=">" width="24"
                        height="24" decoding="async" data-nimg="1" class="breadcrumb_crumbIcon__F6TLQ"
                        style="color:transparent" src="{{ asset('images/arrow-left.png') }}">
                </div>

                <div class="breadcrumb_crumbItem__gzO8K">
                    <div class="breadcrumb_lastTxt__cdw0_">Episodes {{ $episode }}</div>
                </div>
            </div>
        </div>

        <div class="episode_videoArea__rOakl">
            <div class="episode_videoPlace__6Ljk7">
                <div class="" style="width: 100%;">
                    <div class="videoPlayer_videoBox__QzYvq episode_videoPlace__6Ljk7">
                        <video id="videoId" preload="false" autoplay="" poster="{{ $cover }}"
                            src="{{ $videoSrc }}" tabindex="-1" disablepictureinpicture="" disableremoteplayback=""
                            x-webkit-airplay="deny" playsinline="" webkit-playsinline="true" x5-playsinline="true"
                            x5-video-player-type="h5" x5-video-orientation="portraint"
                            controlslist="nodownload noremoteplayback noplaybackrate foobar"></video>
                        <div class="VideoControl_controlBox__lY2MY" style="display: flex;">
                            <div class="VideoControl_stopBox__DP9XE" style="display: block;">
                                <div class="VideoControl_stopBox__DP9XE">
                                    <img alt="" loading="lazy" width="52" height="52" decoding="async"
                                        data-nimg="1" class="VideoControl_pausedIcon__rHcpb"
                                        src="{{ asset('images/play.png') }}" style="color: transparent; display: block;">
                                </div>
                            </div>
                            <div class="VideoControl_controlLine__SJrKc">
                                <div class="VideoControl_timeBox__RyVq_ VideoControl_timeBoxActive__xJ6_0">
                                    <div class="VideoControl_nowTime__KsJlW">
                                        <div class="VideoControl_nowTime__KsJlW">0:00<span
                                                class="VideoControl_durationTime__g6XlU">0:00</span></div>
                                    </div>
                                    <div class="VideoControl_muted___S5Zb">
                                        <img alt="" loading="lazy" width="32" height="32" decoding="async"
                                            style="color: transparent;" data-nimg="1"
                                            class="VideoControl_fullscreenIcon__Utb0x"
                                            src="{{ asset('images/sound.png') }}">
                                        <img alt="" loading="lazy" width="32" height="32" decoding="async"
                                            style="color: transparent; display: block;" data-nimg="1"
                                            class="VideoControl_fullscreenIcon__Utb0x"
                                            src="{{ asset('images/fullsize.png') }}">
                                    </div>
                                </div>
                                <div class="VideoControl_progressBox__8RpRa">
                                    <div class="VideoControl_lineBg__tjdZo">
                                        <div class="VideoControl_lineItem__lvhQR" style="width: 100%;"></div>
                                        <div class="VideoControl_lineDot__JMD_6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="videoIntro_videoIntro__3pcoH">
                <h1 class="videoIntro_videoTit__bwDWf">{{ $data->bookName }}<span> Episodes {{ $episode }} </span>
                </h1>
                <div class="videoIntro_videoScore__1dld9">
                    <img alt="" width="40" height="40" decoding="async" data-nimg="1"
                        class="videoIntro_epoImg__soJEi" style="color:transparent" src="{{ asset('images/star.png') }}">
                    <p class="videoIntro_epoScore__GX_cP"><span id="viewseooa">{{ $data->viewCount }}</span></p>
                </div>
                <div class="videoIntro_videoTag__xzsE0">
                    @foreach ($data->tags as $tag)
                        <a class='videoIntro_tagItem__Yh9CL' href=''>{{ $tag }}</a>
                    @endforeach
                </div>
                <div class="ellipsisIntro_retractIntroBox__T4pgA">{{ $data->introduction }}</div>
            </div>

            <div class="flex justify-center w-full">
                <a href="{{ route('dramas.index') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mb-3"
                    style="color: #fff;">Back to Home</a>
            </div>

            <div class="episodeList_epiList__iv7w_">
                <div class="episodeList_titleList__WTUQd">
                    <p class="episodeList_titleLeft__Fkqc7">Episode List</p>
                    <p class="episodeList_titleRight__JzF7F">(<!-- -->{{ $data->chapterCount }}<!-- -->
                        <!-- -->Episodes<!-- -->)
                    </p>
                </div>
                <div class="episodeList_epilistBox__9Jy4_">
                    @foreach ($chapterlist as $key => $chapter)
                        <a class="episodeList_epiOuter__kJctp" id="{{ $chapter->id . '_Episode-' . ($key + 1) }}"
                            href="{{ route('dramas.video', [$data->bookId, $data->bookNameEn, $chapter->id . '_Episode-' . ($key + 1)]) }}">{{ $key + 1 }}</a>
                    @endforeach
                </div>
            </div>

            <div class="EpisodeDialog_dialogContainer__JCOtQ" hidden>
                <div class="EpisodeDialog_dialogMark__SOMVn"></div>
                <div class="EpisodeDialog_dialogBox__LTeoZ">
                    <div class="EpisodeDialog_headerTop__OthbP">
                        <div class="EpisodeDialog_topInfo__s6_g1">
                            <div class="EpisodeDialog_title__lUtzm">{{ $data->bookName }}</div>
                            <img alt="" loading="lazy" width="48" height="48" decoding="async"
                                data-nimg="1" class="EpisodeDialog_closeIcon__7oU_s"
                                src="{{ asset('images/close-d.png') }}" style="color: transparent;">
                        </div>
                        <div class="EpisodeDialog_titleTab__bWaCr">
                            <div class="EpisodeDialog_tabs__uFL6F EpisodeDialog_tabTopActive__0NHcM">
                                {{ $episode }}-{{ $data->chapterCount }}
                                Episodes</div>
                        </div>
                    </div>
                    <div class="EpisodeDialog_episodeList__WrvmV">
                        @foreach ($chapterlist as $key => $chapter)
                            <a class="EpisodeDialog_episodeItem__Zvsgh"
                                href="{{ route('dramas.video', [$data->bookId, $data->bookNameEn, $chapter->id . '_Episode-' . ($key + 1)]) }}"
                                style="display: inline-block;"><span>{{ $chapter->indexStr }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
    </main>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('css/cf8820e207bda6b8.css') }}" data-n-p="" />
    <link rel="stylesheet" href="{{ asset('css/d8ca4c3c4ee5645f.css') }}" data-n-p="" />
    <link rel="stylesheet" href="{{ asset('css/7fc97ca489c15277.css') }}" data-n-p="" />
    <link rel="stylesheet" href="{{ asset('css/0131b3235f60f403.css') }}" data-n-p="" />
    <style>
        .Video_videoHeader__rB_Ky,
        header {
            display: none;
        }

        .episode_videoArea__rOakl .episode_videoPlace__6Ljk7 {
            height: 100%;
        }

        .videoIntro_videoIntro__3pcoH {
            margin-top: 50%;
        }
    </style>
@endpush
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById("videoId");
            const playPauseBtn = document.querySelector(".VideoControl_stopBox__DP9XE");
            const playIcon = document.querySelector(".VideoControl_pausedIcon__rHcpb");
            const timeBox = document.querySelector(".VideoControl_timeBox__RyVq_");
            const controlBox = document.querySelector(".VideoControl_controlBox__lY2MY");
            const muteBtn = document.querySelector(".VideoControl_muted___S5Zb img:nth-child(1)");
            const fullScreenBtn = document.querySelector(".VideoControl_muted___S5Zb img:nth-child(2)");

            const timeDisplay = document.querySelector(".VideoControl_nowTime__KsJlW");
            const progressBar = document.querySelector(".VideoControl_lineItem__lvhQR");
            const progressBox = document.querySelector(".VideoControl_progressBox__8RpRa");


            function showControls() {
                controlBox.style.display = "flex";
                playPauseBtn.style.display = "block";
                fullScreenBtn.style.display = "block";
                timeBox.classList.add("VideoControl_timeBoxActive__xJ6_0");
            }

            function hideControls() {
                controlBox.style.display = "none";
                playPauseBtn.style.display = "none";
                timeBox.classList.remove("VideoControl_timeBoxActive__xJ6_0");
            }

            playPauseBtn.addEventListener("click", function() {
                if (video.paused) {
                    video.play();
                    playIcon.style.display = "none";
                } else {
                    video.pause();
                    showControls();
                    playIcon.style.display = "block";
                }
            });

            video.addEventListener("play", function() {
                showControls();
                playIcon.style.display = "none";

                let currentPath = window.location.pathname;
                let pathArray = currentPath.split('/');
                let bookId = pathArray[1];
                let episodeFullId = pathArray[3];

                movieHistory[bookId] = movieHistory[bookId] || [];

                if (!movieHistory[bookId].includes(episodeFullId)) {
                    movieHistory[bookId].push(episodeFullId);
                    localStorage.setItem('movieHistory', JSON.stringify(movieHistory));
                }

                const episodeElement = document.getElementById(episodeFullId);
                if (episodeElement) {
                    episodeElement.classList.add('!bg-red-300');
                }
            });

            video.addEventListener("pause", function() {
                showControls();
                playIcon.style.display = "block";
                timeBox.classList.add("VideoControl_timeBoxActive__xJ6_0");
            });

            playIcon.addEventListener("click", function(event) {
                event.stopPropagation(); // Mencegah event merambat ke elemen lain
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            });

            video.addEventListener("mousemove", function() {
                showControls();
                clearTimeout(video.controlTimeout);
                video.controlTimeout = setTimeout(hideControls, 3000);
            });

            video.addEventListener("click", function() {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            });

            muteBtn.addEventListener("click", function() {
                video.muted = !video.muted;
                muteBtn.src = video.muted ? "images/ic_muted.png" : "images/ic_nomuted.png";
            });

            fullScreenBtn.addEventListener("click", function() {
                if (!document.fullscreenElement) {
                    video.requestFullscreen();
                    fullScreenBtn.src = "images/fullsize.png";
                } else {
                    document.exitFullscreen();
                    fullScreenBtn.src = "images/fullsize.png";
                }
            });

            video.addEventListener("timeupdate", function() {
                let currentTime = formatTime(video.currentTime);
                let duration = formatTime(video.duration);
                timeDisplay.innerHTML =
                    `<div class="VideoControl_nowTime__KsJlW">${currentTime}<span class="VideoControl_durationTime__g6XlU">${duration}</span></div>`;
                let progress = (video.currentTime / video.duration) * 100;
                progressBar.style.width = `${progress}%`;
            });

            function formatTime(seconds) {
                let min = Math.floor(seconds / 60);
                let sec = Math.floor(seconds % 60);
                return `${min}:${sec < 10 ? "0" : ""}${sec}`;
            }

            fullScreenBtn.addEventListener("click", function() {
                if (!document.fullscreenElement) {
                    video.requestFullscreen();
                } else {
                    document.exitFullscreen();
                }
            });

            progressBox.addEventListener("click", function(e) {
                const rect = progressBox.getBoundingClientRect();
                const offsetX = e.clientX - rect.left;
                const newTime = (offsetX / rect.width) * video.duration;
                video.currentTime = newTime;
            });

            video.addEventListener("ended", function() {
                console.log('Video ended');

                let url = window.location.href;
                let episode = url.split('/').pop().split('-').pop();
                let chapterCount = {!! json_encode($data->chapterCount) !!};
                let lastEpisode = false;
                if (episode == chapterCount) {
                    lastEpisode = true;
                }
                if (!lastEpisode) {
                    let nextEpisode = parseInt(episode) + 1;
                    let nextUrl = url.replace('Episode-' + episode, 'Episode-' + nextEpisode);
                    window.location.href = nextUrl;
                }
            });

            hideControls();

            let movieHistory = JSON.parse(localStorage.getItem('movieHistory')) || {};
            const bookId = window.location.pathname.split('/')[1];
            if (movieHistory[bookId]) {
                movieHistory[bookId].forEach(element => {
                    const episodeElement = document.getElementById(element);
                    if (episodeElement) {
                        episodeElement.classList.add('!bg-red-300');
                    }
                });
            }
        });
    </script>
@endpush
