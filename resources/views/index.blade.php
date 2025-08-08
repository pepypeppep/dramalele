@extends('master')

@section('content')
    <main class="browse_browseBox__hZiZ_">
        <div class="browse_browseContent__hDbPH">
            <div class="browse_browseContent2__Ci_x5">
                <div class="FirstList_firstListBox__eN_W1">
                    @foreach ($booklist as $data)
                        <div class="FirstList_itemBox__AfNNm">
                            <a class="FirstList_bookImage__ZbBGO image_imageBox__Mubn5"
                                href="{{ $data->bookId }}/{{ $data->bookNameEn }}"><img alt="{{ $data->bookName }}"
                                    loading="lazy" width="120" height="162" decoding="async" data-nimg="1"
                                    class="image_imageItem__IZeBT" style="color:transparent" src="{{ $data->cover }}"></a>
                            <a class="FirstList_chapterCount__OyG6t"
                                href="{{ $data->bookId }}/{{ $data->bookNameEn }}">{{ $data->chapterCount }}
                                Episodes</a>
                            <a class="FirstList_bookName__cULmf"
                                href="{{ $data->bookId }}/{{ $data->bookNameEn }}">{{ $data->bookName }}</a>
                            <div class="FirstList_bookNameBox__LdUXf">
                                <a class="FirstList_bookNameHover__f03t0"
                                    href="{{ $data->bookId }}/{{ $data->bookNameEn }}">{{ $data->bookName }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div>
                    <div class="MorePagination_paginationWrap__2K3zJ">
                        <div class="MorePagination_pageItem__847mF" style="opacity: 0.5; pointer-events: none;">
                            <img alt="Previous" loading="lazy" width="32" height="32" decoding="async"
                                class="MorePagination_prevNextIcon__6bs7h" style="color:transparent"
                                src="{{ asset('images/pre_1.png') }}">
                        </div>

                        <div class="MorePagination_linkItem__AQVsa">
                            {{ $pageNo }} / {{ $pages }} </div>

                        <a class="MorePagination_linkItem__AQVsa" href="?page=2">
                            <img alt="Next" loading="lazy" width="32" height="32" decoding="async"
                                class="MorePagination_prevNextIcon__6bs7h" style="color:transparent"
                                src="{{ asset('images/next_1.png') }}">
                        </a>
                    </div>

                    <div class="paginationCom_pageContent__wspPw">
                        @if ($pageNo > 1)
                            <a class="paginationCom_prevBtn__tSFZr"
                                href="{{ $pageNo == 2 ? '/' : '?page=' . ($pageNo - 1) }}">
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
                            <a class="paginationCom_normalLi__YFrvZ" href="/">1</a>
                            <div class="paginationCom_omission__2F81x">…</div>
                        @endif

                        @for ($i = $pageNo - 2; $i <= $pageNo + 2; $i++)
                            @if ($i >= 1 && $i <= $pages)
                                @if ($i == $pageNo)
                                    <div class="paginationCom_activePage__Ke4Ik">{{ $i }}</div>
                                @else
                                    <a class="paginationCom_normalLi__YFrvZ"
                                        href="{{ $i == 1 ? '/' : '?page=' . $i }}">{{ $i }}</a>
                                @endif
                            @endif
                        @endfor

                        @if ($pageNo < $pages - 2)
                            <div class="paginationCom_omission__2F81x">…</div>
                            <a class="paginationCom_normalLi__YFrvZ"
                                href="?page={{ $pages }}">{{ $pages }}</a>
                        @endif

                        @if ($pageNo < $pages)
                            <a class="paginationCom_nextBtn__E0BGd"
                                href="{{ $pageNo + 1 == $pages ? '?page=' . ($pageNo + 1) : '?page=' . ($pageNo + 1) }}">
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
                </div>
            </div>
        </div>
    </main>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('css/ff991deaacf276d3.css') }}" data-n-p="" />
@endpush
