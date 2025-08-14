@extends('master')
@php
    $title_slug = strtolower(str_replace(' ', '-', $data->book_title));
@endphp
@section('content')
    <main class="film_detailWrap__N7Nge">
        <div class="film_detailHeader__oxs7K">
            <div class="breadcrumb_crumbsWrap__SWofi">
                <div class="breadcrumb_crumbItem__gzO8K">
                    <a href="/">Home</a>
                    <img alt=">" width="24" height="24" decoding="async" data-nimg="1"
                        class="breadcrumb_crumbIcon__F6TLQ" style="color:transparent"
                        src="{{ asset('images/arrow-left.png') }}" />
                </div>
                <div class="breadcrumb_crumbItem__gzO8K">
                    <div class="breadcrumb_lastTxt__cdw0_">{{ $data->book_title }}</div>
                </div>
            </div>
        </div>

        <div class="film_container__I8GPO">
            <div class="film_detailBox__pdSWY">
                <div class="film_bookCoverBox__szX0Y">
                    <img alt="{{ $data->book_title }}" fetchpriority="high" width="280" height="378" decoding="async"
                        data-nimg="1" class="film_bookCover__YRcsa" id="imageToShare" style="color:transparent"
                        src="{{ $data->book_pic }}" />
                </div>
                <h1 class="film_bookName__ys_T3">{{ $data->book_title }}</h1>
                <p class="film_pcEpiNum__9Ja7z">{{ $data->total }} Episodes</p>
                <p class="film_pcIntro__BB1Ox">{{ $data->special_desc }}</p>
                <div class="film_tagBox__XSPYj">
                    @foreach ($data->tag as $tag)
                        <a class='film_tagItem__qLwLn' href=''>{{ $tag }}</a>
                    @endforeach
                </div>
                <div class="film_playBtnBox__D7PQG">
                    <a class="film_playBtn__yM_Mp"
                        href="{{ route('reelshort.video', ['episode-' . $chapterlist[0]->serial_number . '-' . $title_slug . '-' . $data->book_id . '-' . $chapterlist[0]->chapter_id]) }}">Watch
                        Now</a>
                </div>
                <div class="film_introBox__HQyUv">
                    <p class="film_introTitle__75SR3">Introduction</p>
                    <div class="ellipsisIntro_retractIntroBox__T4pgA">{{ $data->special_desc }}</div>
                </div>

            </div>
            <div class="pcSeries_episodeListBox___2nz2">
                <div class="pcSeries_topInfo__CbWQV">
                    <div class="pcSeries_episodeTitle__9I5WJ">Episode List</div>
                    <div class="pcSeries_allCounts__Dp5zX">({{ $data->total }} Episodes)</div>
                </div>
                <div class="pcSeries_listInfo__6ay2n">
                    @foreach ($chapterlist as $key => $chapter)
                        <div class="pcSeries_listItem__sd0Xp">
                            <a class="pcSeries_imgBox___UvIY image_imageBox__Mubn5 image_imageScaleBox__JFwzM"
                                href="{{ route('reelshort.video', ['episode-' . $chapter->serial_number . '-' . $title_slug . '-' . $data->book_id . '-' . $chapter->chapter_id]) }}">
                                <img alt="Episodes 1" loading="lazy" width="70" height="94" decoding="async"
                                    data-nimg="1" class="image_imageItem__IZeBT" src="{{ $data->book_pic }}"
                                    style="color: transparent;"></a>
                            <a class="pcSeries_rightIntro__UFC_8"
                                href="{{ route('reelshort.video', ['episode-' . $chapter->serial_number . '-' . $title_slug . '-' . $data->book_id . '-' . $chapter->chapter_id]) }}">
                                <span class="pcSeries_title__R9vip">{{ $data->book_title }}</span><span
                                    class="pcSeries_pageNum__xkXBk">EP.{{ $chapter->serial_number }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="film_episodeNav__1qS0c">
                <div class="film_catalogBox__0DHTA">
                    <div class="film_leftInfo__g7WQX">
                        <p class="film_innerPt__dVDtN">Episode List</p>
                        <p class="film_innerPl__Ar2O5">({{ $data->total }} Episodes)</p>
                    </div>
                    <img alt="" width="24" height="24" decoding="async" data-nimg="1"
                        class="film_arrowIcon__uaML8" src="{{ asset('images/arrow-left.png') }}"
                        style="color: transparent;">

                </div>
            </div>
        </div>

        <div class="EpisodeDialog_dialogContainer__JCOtQ" hidden="">
            <div class="EpisodeDialog_dialogMark__SOMVn"></div>
            <div class="EpisodeDialog_dialogBox__LTeoZ">
                <div class="EpisodeDialog_headerTop__OthbP">
                    <div class="EpisodeDialog_topInfo__s6_g1">
                        <div class="EpisodeDialog_title__lUtzm">{{ $data->book_title }}
                        </div>
                        <img alt="" loading="lazy" width="48" height="48" decoding="async" data-nimg="1"
                            class="EpisodeDialog_closeIcon__7oU_s" src="{{ asset('images/close-d.png') }}"
                            style="color: transparent;">
                    </div>
                    <div class="EpisodeDialog_titleTab__bWaCr">
                        <div class="EpisodeDialog_tabs__uFL6F EpisodeDialog_tabTopActive__0NHcM">
                            1-{{ $data->total }} Episodes
                        </div>
                    </div>
                </div>
                <div class="EpisodeDialog_episodeList__WrvmV">
                    @foreach ($chapterlist as $key => $chapter)
                        <a class="EpisodeDialog_episodeItem__Zvsgh"
                            id="{{ $chapter->chapter_id . '-Episode-' . $chapter->serial_number }}"
                            href="{{ route('reelshort.video', ['episode-' . $chapter->serial_number . '-' . $title_slug . '-' . $data->book_id . '-' . $chapter->chapter_id]) }}"
                            style="display: inline-block;"><span>{{ ltrim($chapter->serial_number, '0') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('css/cf8820e207bda6b8.css') }}" data-n-p="" />
@endpush
@push('script')
    <script>
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
