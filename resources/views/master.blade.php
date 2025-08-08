<!DOCTYPE html>
<html>

<head>
    <meta charSet="utf-8" />
    <title> DramaLele</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta http-equiv="Content-Security-Policy" />
    <meta name="mobile-web-app-capable" content="yes" />
    <link rel="icon" href="{{ asset('images/logo.png') }}" />
    <meta name="next-head-count" content="33" />
    <script id="rem_flexible" data-nscript="beforeInteractive">
        window.addEventListener("keydown", function(e) {
            if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                e.preventDefault()
            }
        });
        (function flexible(window, document) {
            var docEl = document.documentElement;

            function setPageFontsize() {
                document.documentElement.style.setProperty('--vh', (window.innerHeight / 100) + 'px');
                var clientWidth = window.innerWidth || docEl.clientWidth;
                if (clientWidth <= 768) {
                    var rem = 100 * (clientWidth / 750);
                    rem && (docEl.style.fontSize = rem + 'px');
                } else {
                    docEl.style.fontSize = '83.3px'
                }
                if (window.resizeScreen) {
                    window.resizeScreen();
                }
            }
            setPageFontsize();
            setTimeout(function() {
                setPageFontsize()
            }, 10)
            var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
            window.addEventListener(resizeEvt, setPageFontsize);
            window.addEventListener("pageshow", function(e) {
                if (e.persisted) {
                    setPageFontsize()
                }
            })
        })(window, document);
    </script>

    <link rel="stylesheet" href="{{ asset('css/3a766e95339d2e30.css') }}" data-n-g="" />
    @stack('style')
    <link rel="stylesheet" href="{{ asset('css/03f43baa862a5120.css') }}" data-n-p="" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <style>
        .PcHeader_navBox__ZpLDU .PcHeader_navItemActive__KexnK {
            color: #000;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div id="__next">
        <header class="MHeader_headerWrap__I8s6L">
            <div class="MHeader_homeHeaderBox__sT00I">
                <div class="MHeader_navMenu__TtP3C">
                    <a class="MHeader_navItem__zc4sl" href="/">Home</a>
                </div>
                <div class="search_navRight__RCdfn">
                    <img alt="" loading="lazy" width="16" height="16" decoding="async" data-nimg="1"
                        class="search_navRightIcon__uQIzB" style="color:transparent"
                        src="{{ asset('images/home_search.png') }}" />
                    <input class="search_navRightInput__Z_cka" name="search" type="search" placeholder="Search"
                        value="{{ request('q') }}"
                        onkeydown="if(event.key === 'Enter'){window.location.href = '/search?q=' + encodeURIComponent(this.value);}" />
                </div>
                {{-- <div class="MHeader_navRight__vPNZu">
                    <a href="search">
                        <img alt="search" loading="lazy" width="48" height="48" decoding="async" data-nimg="1"
                            class="MHeader_searchIcon__zBerC" src="{{ asset('images/home_search.png') }}"
                            style="color: transparent;">
                    </a>
                </div> --}}
            </div>
        </header>

        <div class="PcHeader_navWrap__kKVZ8">
            <div class="PcHeader_navContent__xHEx3">
                <div class="PcHeader_navLeft__T8GeY">
                    <a class="PcHeader_logoTxtBox__MVh19" href="/">
                        <img alt="DramaBox" loading="lazy" width="181" height="40" decoding="async" data-nimg="1"
                            class="PcHeader_logoIcon__VDWl7" style="color:transparent"
                            src="{{ asset('images/m-logo.png') }}" />
                    </a>
                    <div class="PcHeader_navBox__ZpLDU">
                        <a class="PcHeader_navItemActive__KexnK" href="/"><span
                                class="PcHeader_navItemLabel__KpTG7">Home</span></a>
                    </div>
                </div>
                <div class="search_navRight__RCdfn">
                    <img alt="" loading="lazy" width="16" height="16" decoding="async" data-nimg="1"
                        class="search_navRightIcon__uQIzB" style="color:transparent"
                        src="{{ asset('images/home_search.png') }}" />
                    <input class="search_navRightInput__Z_cka" name="search" type="search" placeholder="Search"
                        value="{{ request('q') }}"
                        onkeydown="if(event.key === 'Enter'){window.location.href = '/search?q=' + encodeURIComponent(this.value);}" />
                </div>
            </div>
        </div>

        @yield('content')

        {{-- <footer class="PcFooter_footerWrap__M1H43">
            <p class="PcFooter_company__s_7Bl">© <!-- -->DramaLele<!-- -->, <!-- -->All Rights Reserved</p>
        </footer> --}}
    </div>


    <script src="{{ asset('js/js4itjgjee4tg.js') }}"></script>
    @stack('script')
</body>

</html>
