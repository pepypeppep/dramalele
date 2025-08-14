@extends('master')

@section('content')
    <div class="search_searchWrap__4tSPy">
        <div class="search_searchBox__hxwgc">
            <div class="search_searchHeader__bL0IU">
                <span>{{ $totalNum }}</span> results were found for <span>{{ request('q') }}</span>
            </div>
            @foreach ($booklist as $data)
                <div class="RankingsBookItem_rankingsBookWrap__Dzv8Y">
                    <div class="RankingsBookItem_imageItem1Wrap__KhEDB">
                        <a class="RankingsBookItem_bookImage__xhWCo image_imageBox__Mubn5 image_imageScaleBox__JFwzM"
                            href="{{ route('reelshort.show', [$data->book_id, strtolower(str_replace(' ', '-', $data->book_title))]) }}">
                            <img alt="{{ strtolower(str_replace(' ', '-', $data->book_title)) }}" loading="lazy" width="150"
                                height="200" decoding="async" data-nimg="1" class="image_imageItem__IZeBT"
                                style="color:transparent" src="{{ $data->book_pic }}">
                        </a>
                        <div class="RankingsBookItem_bookInfo__pgA5P">
                            <a class="RankingsBookItem_bookName__kmTaH"
                                href="{{ route('reelshort.show', [$data->book_id, strtolower(str_replace(' ', '-', $data->book_title))]) }}">
                                <span
                                    style="color: #FF375F">{{ strtolower(str_replace(' ', '-', $data->book_title)) }}</span>
                            </a>
                            <a class="RankingsBookItem_bookLine2__ac9BK"
                                href="{{ route('reelshort.show', [$data->book_id, strtolower(str_replace(' ', '-', $data->book_title))]) }}">{{ $data->chapter_count }}<span>Episodes</span></a>
                            <a class="RankingsBookItem_intro__oRUOH"
                                href="{{ route('reelshort.show', [$data->book_id, strtolower(str_replace(' ', '-', $data->book_title))]) }}">{{ $data->special_desc }}</a>
                        </div>
                        <a class="RankingsBookItem_readBtn__J_9gB"
                            href="{{ route('reelshort.show', [$data->book_id, strtolower(str_replace(' ', '-', $data->book_title))]) }}">Watch
                            Now</a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($totalPage > 1)
            <div class="paginationCom_pageContent__wspPw">
                @if ($pageNo > 1)
                    <a class="paginationCom_prevBtn__tSFZr"
                        href="/search?q={{ request('q') }}{{ $pageNo == 2 ? '/' : '&page=' . ($pageNo - 1) }}">
                        <img alt="prev" loading="lazy" width="14" height="14" decoding="async"
                            class="paginationCom_prevNextIcon__ZxNjw" style="color:transparent"
                            src="{{ asset('images/next_2.png') }}">
                    </a>
                @else
                    <div class="paginationCom_prevNoMore__k9A75" style="opacity: 0.5; pointer-events: none;">
                        <img alt="prev" loading="lazy" width="14" height="14" decoding="async"
                            class="paginationCom_prevNextIcon__ZxNjw" style="color:transparent"
                            src="{{ asset('images/next_2.png') }}">
                    </div>
                @endif

                @if ($pageNo > 3)
                    <a class="paginationCom_normalLi__YFrvZ" href="/search?q={{ request('q') }}">1</a>
                    <div class="paginationCom_omission__2F81x">…</div>
                @endif

                @for ($i = $pageNo - 2; $i <= $pageNo + 2; $i++)
                    @if ($i >= 1 && $i <= $pages)
                        @if ($i == $pageNo)
                            <div class="paginationCom_activePage__Ke4Ik">{{ $i }}</div>
                        @else
                            <a class="paginationCom_normalLi__YFrvZ"
                                href="/search?q={{ request('q') }}{{ $i == 1 ? '/' : '&page=' . $i }}">{{ $i }}</a>
                        @endif
                    @endif
                @endfor

                @if ($pageNo < $pages - 2)
                    <div class="paginationCom_omission__2F81x">…</div>
                    <a class="paginationCom_normalLi__YFrvZ"
                        href="/search?q={{ request('q') }}&page={{ $pages }}">{{ $pages }}</a>
                @endif

                @if ($pageNo < $pages)
                    <a class="paginationCom_nextBtn__E0BGd"
                        href="/search?q={{ request('q') }}{{ $pageNo + 1 == $pages ? '&page=' . ($pageNo + 1) : '&page=' . ($pageNo + 1) }}">
                        <img alt="next" loading="lazy" width="14" height="14" decoding="async"
                            class="paginationCom_prevNextIcon__ZxNjw" style="color:transparent"
                            src="{{ asset('images/next_1.png') }}">
                    </a>
                @else
                    <div class="paginationCom_nextNoMore__24x_P" style="opacity: 0.5; pointer-events: none;">
                        <img alt="next" loading="lazy" width="14" height="14" decoding="async"
                            class="paginationCom_prevNextIcon__ZxNjw" style="color:transparent"
                            src="{{ asset('images/next_1.png') }}">
                    </div>
                @endif
            </div>
        @endif

    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('css/092978e99d76a4da.css') }}" data-n-p="" />
@endpush
