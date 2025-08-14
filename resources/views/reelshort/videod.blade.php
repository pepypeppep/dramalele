@extends('master')

@php
    $cover = str_replace('@w=100&h=135', '', $chapterlist[$episode - 1]->cover);
@endphp
@section('content')
    <main class="Video_videoWrap__HUe7w">
        <div class="Video_videoHeader__rB_Ky">
            <div class="breadcrumb_crumbsWrap__SWofi">
                <div class="breadcrumb_crumbItem__gzO8K">
                    <a href="/">Home</a><img alt=">" width="24" height="24" decoding="async" data-nimg="1"
                        class="breadcrumb_crumbIcon__F6TLQ" src="{{ asset('images/arrow-left.png') }}"
                        style="color: transparent;">
                </div>
                <div class="breadcrumb_crumbItem__gzO8K">
                    <a href="drama?id=41000119495&lang=en">{{ $data->bookName }}</a>
                    <img alt=">" width="24" height="24" decoding="async" data-nimg="1"
                        class="breadcrumb_crumbIcon__F6TLQ" src="{{ asset('images/arrow-left.png') }}"
                        style="color: transparent;">
                </div>
                <div class="breadcrumb_crumbItem__gzO8K">
                    <div class="breadcrumb_lastTxt__cdw0_">Episodes {{ $episode }}</div>
                </div>
            </div>
        </div>

        <div class="pcEpisode_videoBox__658Je">
            <div class="pcEpisode_leftVideo__qV0HP" id="videoContainers">
                <div style="background: url({{ $cover }}) center center / auto 100% no-repeat #1a1a1a;"
                    class="pcEpisode_videoContainerStart___u5El">
                    <img alt="Play button" loading="lazy" width="52" height="52" decoding="async" data-nimg="1"
                        class="pcEpisode_videoStart__IcAdF" style="color: transparent; cursor: pointer;"
                        src="{{ asset('images/play.png') }}" />
                </div>
            </div>
            <div class="pcEpisode_leftVideo__qV0HP" id="videoContainer" style="display: none;">
                <div style="background: url('{{ $cover }}') center center / auto 100% no-repeat #1a1a1a;"
                    class="pcEpisode_videoContainer__5hYji">
                    <video id="video_pc_id" preload="false" autoplay poster="{{ $cover }}" tabindex="-1" controls
                        disablepictureinpicture disableremoteplayback x-webkit-airplay="deny" playsinline
                        webkit-playsinline="true" x5-playsinline="true" x5-video-player-type="h5"
                        controlslist="nodownload noremoteplayback noplaybackrate">
                        <source src="{{ $videoSrc }}" type="video/mp4" />
                    </video>
                </div>
            </div>

            <div class="RightList_rightBox__9OVp0">
                <div class="RightList_rightTop__Blgm4">
                    <span class="RightList_title__09Jv_">Episodes</span>
                    <span class="RightList_current__B8KDw">({{ $episode }}/{{ $data->chapterCount }})</span>
                </div>
                <div class="RightList_tabHeader__ZwNKK">
                    {{-- <div class="RightList_tabTitle__zvZRp RightList_tabTitleActive__ySX78" data-tab="1">
                        {{ $tabData[0] }}</div>
                    <div class="RightList_tabTitle__zvZRp " data-tab="2">{{ $tabData[1] }}</div> --}}
                </div>
                <div class="RightList_tabContent__E2D_a" data-tab="1">
                    @foreach ($chapterlist as $key => $chapter)
                        <a class="RightList_linkText__86R_r" title="{{ $data->bookName }} {{ $chapter->indexStr }}"
                            id="{{ $chapter->id . '_Episode-' . ($key + 1) }}"
                            href="{{ route('dramas.video', [$data->bookId, $data->bookNameEn, $chapter->id . '_Episode-' . ($key + 1)]) }}"
                            style="display: inline-block;">{{ ltrim($chapter->indexStr, '0') }}</a>
                    @endforeach
                </div>
                <script>
                    document.querySelectorAll('.RightList_tabTitle__zvZRp').forEach(tab => {
                        tab.addEventListener('click', function() {
                            let tabId = this.getAttribute('data-tab');

                            document.querySelectorAll('.RightList_tabTitle__zvZRp').forEach(t => t.classList.remove(
                                'RightList_tabTitleActive__ySX78'));
                            this.classList.add('RightList_tabTitleActive__ySX78');

                            document.querySelectorAll('.RightList_tabContent__E2D_a').forEach(list => list.style
                                .display = 'none');
                            document.querySelector('.RightList_tabContent__E2D_a[data-tab="' + tabId + '"]').style
                                .display = 'block';
                        });
                    });
                </script>
            </div>
        </div>
        <div class="pcEpisode_videoInfo__PmvZz">
            <h1 class="pcEpisode_videoTitle__3jWfu">{{ $data->bookName }}<span> Episodes {{ $episode }}</span></h1>
            <div class="pcEpisode_videoStar__q1Dc0">
                <img alt="" width="24" height="24" decoding="async" data-nimg="1"
                    class="pcEpisode_imageStar__Ki_yh" src="{{ asset('images/star.png') }}"
                    style="color: transparent;"><span class="pcEpisode_videoScore__hUrWc"
                    id="viewseooa">{{ $data->viewCount }}</span>
            </div>
            <p class="pcEpisode_videoDesc__w9PEx">{{ $data->bookName }} Episodes {{ $episode }},
                {{ $data->introduction }}</p>

            <div class="pcEpisode_tagBox__GdklB">
                @foreach ($data->tags as $tag)
                    <a class='pcEpisode_tagItem__AqYwI' href=''>{{ $tag }}</a>
                @endforeach
            </div>

            <div class="relatedEpisode_relatedEpisode__l_NFQ">
                <div class="relatedEpisode_relatedTitle__5tQl5">Episode List</div>
                <div class="relatedEpisode_listInfo__AXEOT">
                    @foreach ($chapterlist as $key => $chapter)
                        <div class="relatedEpisode_listItem__PNXFG">
                            <div class="lazyload-wrapper relatedEpisode_imgBox__05ArS image_imageLazyBox__ExNZG">
                                <div class="lazyload-wrapper relatedEpisode_imgBox__05ArS image_imageLazyBox__ExNZG"><a
                                        class="relatedEpisode_imgBox__05ArS image_imageBox__Mubn5 image_imageScaleBox__JFwzM"
                                        href="{{ route('dramas.video', [$data->bookId, $data->bookNameEn, $chapter->id . '_Episode-' . ($key + 1)]) }}"><img
                                            alt="{{ $data->bookName }}" loading="lazy" width="70" height="94"
                                            decoding="async" data-nimg="1" class="image_imageItem__IZeBT"
                                            src="{{ $chapter->cover }}" style="color: transparent;"></a></div>
                            </div>
                            <a class="relatedEpisode_rightIntro__y7zZA"
                                href="{{ route('dramas.video', [$data->bookId, $data->bookNameEn, $chapter->id . '_Episode-' . ($key + 1)]) }}"><span
                                    class="relatedEpisode_title__eygbR">{{ $data->bookName }}</span><span
                                    class="relatedEpisode_pageNum__W_ulP">EP. {{ $key + 1 }}</span></a>
                        </div>
                    @endforeach
                    {{-- <div class="relatedEpisode_listItem__PNXFG">
                        <div class="lazyload-wrapper relatedEpisode_imgBox__05ArS image_imageLazyBox__ExNZG">
                            <div class="lazyload-wrapper relatedEpisode_imgBox__05ArS image_imageLazyBox__ExNZG"><a
                                    class="relatedEpisode_imgBox__05ArS image_imageBox__Mubn5 image_imageScaleBox__JFwzM"
                                    href="video?id=41000119495&episode=597880534&lang=en"><img
                                        alt="{{ $data->bookName }}" loading="lazy" width="70" height="94"
                                        decoding="async" data-nimg="1" class="image_imageItem__IZeBT"
                                        src="https://vres.dramaboxdb.com/43/5x9/59x4/594x9/59491100014/597880534_1/597880534.mp4.jpg@w=100&amp;h=135"
                                        style="color: transparent;"></a></div>
                        </div>
                        <a class="relatedEpisode_rightIntro__y7zZA"
                            href="video?id=41000119495&episode=597880534&lang=en"><span
                                class="relatedEpisode_title__eygbR">{{ $data->bookName }}</span><span
                                class="relatedEpisode_pageNum__W_ulP">EP. 1</span></a>
                    </div> --}}

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
@endpush
@push('script')
    <script>
        const playButton = document.querySelector('.pcEpisode_videoStart__IcAdF');
        const videoContainer = document.getElementById('videoContainer');
        const videoContainers = document.getElementById('videoContainers');
        const video = document.getElementById('video_pc_id');

        let videoContainersClicked = false;

        videoContainers.addEventListener('click', () => {
            videoContainersClicked = true;
        });

        playButton.addEventListener('click', () => {
            if (videoContainersClicked) {
                videoContainer.style.display = 'block';
                videoContainers.style.display = 'none';

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

                video.play();
            } else {
                videoContainer.style.display = 'none';
                video.pause();
                video.currentTime = 0;
            }
        });

        window.addEventListener('load', () => {
            video.pause();
            video.currentTime = 0;
        });

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
    </script>
@endpush
