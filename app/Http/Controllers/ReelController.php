<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // https://www.reelshort.com/_next/data/8241968/en/shelf/new-release-short-movies-dramas-118355/2.json
        $page = $request->input('page', 1);
        $url = config('services.reelshort.web') . '/_next/data/' . $this->buildId() . '/en' . $this->newReleaseLink() . '/' . $page . '.json';
        $req = Http::get($url);
        $response = json_decode($req->body());
        $data = $response->pageProps;
        $pages = $data->totalPage;
        $pageNo = $data->page;

        return view('reelshort.index', compact('data', 'pages', 'pageNo'));
    }

    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        // https://www.reelshort.com/_next/data/8241968/en/search.json?keywords=a&page=1
        $page = $request->input('page', 1);
        $q = $request->input('q');
        $url = config('services.reelshort.web') . '/_next/data/' . $this->buildId() . '/en/search.json?keywords=' . $q . '&page=' . $page;
        $req = Http::get($url);
        $response = json_decode($req->body());
        $pageNo = $response->pageProps->page;
        $totalNum = $response->pageProps->total;
        $pages = $totalNum;
        $booklist = $response->pageProps->books;
        $totalPage = $response->pageProps->totalPage;

        return view('reelshort.search', compact('booklist', 'totalNum', 'pageNo', 'pages', 'totalPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id, $slug)
    {
        $slug = str_replace("'", "-", str_replace(['.', ':', ','], '', $slug));
        // https://www.reelshort.com/_next/data/8241968/en/movie/the-housewife-who-touched-the-stars-67dba01135d052518404417c.json
        $req = Http::get(config('services.reelshort.web') . '/_next/data/' . $this->buildId() . '/en/movie/' . $slug . '-' . $id . '.json');
        $response = json_decode($req->body());
        $data = $response->pageProps->data;
        $chapterlist = $response->pageProps->data->online_base;

        return view('reelshort.show', compact('data', 'chapterlist'));
    }

    /**
     * Display the specified resource.
     */
    public function video(Request $request, $slug)
    {
        $slug = str_replace("'", "-", str_replace(['.', ':', ','], '', $slug));
        $slugParts = explode('-', $slug);
        $chaptId = $slugParts[count($slugParts) - 2];
        $id = end($slugParts);

        // https://www.reelshort.com/_next/data/8241968/en/episodes/episode-1-the-housewife-who-touched-the-stars-67dba01135d052518404417c-il185cjzcj.json
        $url = config('services.reelshort.web') . '/_next/data/' . $this->buildId() . '/en/episodes/' . $slug . '.json';
        $urlTrailer = str_replace('episode-0', 'trailer', config('services.reelshort.web') . '/_next/data/' . $this->buildId() . '/en/episodes/' . $slug . '.json');
        $req = Http::get($url);
        $response = json_decode($req->body());

        if (isset($response->pageProps->__N_REDIRECT)) {
            $req = Http::get($urlTrailer);
            $response = json_decode($req->body());
        }

        $data = $response->pageProps->data;

        $slugMin = str_replace([$chaptId, $id, '--'], '', $slug);
        $x = array_slice(explode('-', $slugMin), 2);
        $slugMin = implode('-', $x);

        $url2 = config('services.reelshort.web') . '/_next/data/' . $this->buildId() . '/en/movie/' . $slugMin . '-' . $chaptId . '.json';
        $req2 = Http::get($url2);
        $response2 = json_decode($req2->body());
        $chapterlist = $response2->pageProps->data->online_base;

        // $movieId = explode('_', $episode)[0];
        // $episode = explode('-', $episode)[1];

        // $response = Http::withHeaders([
        //     'Tn' => 'Bearer ' . env('BEARER_TOKEN'),
        //     'Pline' => 'ANDROID',
        //     'Version' => '401',
        //     'Vn' => '4.0.1',
        //     'Userid' => '260055092',
        //     'Cid' => 'XDASEO1000000',
        //     'Package-Name' => 'com.storymatrix.drama',
        //     'Apn' => '2',
        //     'Device-Id' => '76040001-c487-4662-a4e7-c8acb6a9b655',
        //     'Android-Id' => '000000004eba8bae4eba8bae00000000',
        //     'Language' => 'en',
        //     'Current-Language' => 'en',
        //     'P' => '40',
        //     'Local-Time' => '2025-08-07 19:50:59.820 +0700',
        //     'Time-Zone' => '+0700',
        //     'Md' => 'Redmi Note 5',
        //     'Ov' => '9',
        //     'Mf' => 'XIAOMI',
        //     'Tz' => '-420',
        //     'Mcc' => '510',
        //     'Brand' => 'xiaomi',
        //     'Srn' => '1080x2160',
        //     'Ins' => '1754550077083',
        //     'Mbid' => '41000109056',
        //     'Mchid' => 'XDASEO1000000',
        //     'Nchid' => 'DRA1000042',
        //     'Lat' => '0',
        //     'Build' => 'Build/PKQ1.180904.001',
        //     'Locale' => 'en_US',
        //     'Over-Flow' => 'new-fly',
        //     'Instanceid' => 'f945e86b9e1953f086998f84f8ce8c06',
        //     'Country-Code' => 'ID',
        //     'Store-Source' => 'store_google',
        //     'Afid' => '1754550077072-7519988131849321120',
        //     'Is_vpn' => '0',
        //     'Is_root' => '1',
        //     'Is_emulator' => '0',
        //     'Sn' => 'rFBiMlOYuhlX18MSOsG/mH4nVzGgfHJEZ0pL8DbCS7neqiHAkBATjcu1Sjh9OuFDClYbtUaun4jjoXtpt16npXVEduWrFAi2YS8TZrG9pzf2sBtWU/qs2HtPrGpOudlMnDY9yLrED7ty8wbWy5jXzWmu7xOUMqCpDwQF4CFh0P6PMHa2EYlmDBb9jQw2Cq+f2IhEedjYV1OxyboLGpCd1R3RqQwY2L3m9pw4uj363I8trQLYujRDJ3d5vCVkLl9tp/TM/vAMCvVg50Wvo3Ly4cpyydQRq4TNBObhuNJ3EpmD36TlppW9KastcjqJx/bwriNP/f0YeMrZbYXX9c76qQ==',
        //     'Active-Time' => '495946',
        //     'Content-Type' => 'application/json; charset=UTF-8',
        //     'Accept-Encoding' => 'gzip, deflate, br',
        //     'User-Agent' => 'okhttp/4.10.0'
        // ])->post(config('services.reelshort.api') . '/drama-box/chapterv2/batch/load', [
        //     'index' => $episode,
        //     'bookId' => $id
        // ]);

        // // Decode the JSON response
        // $response = json_decode($response);

        $videoSrc = 'asd';

        return view('reelshort.video', compact('data', 'chapterlist', 'videoSrc'));
    }

    public function buildId()
    {
        $urlx = 'https://www.reelshort.com';
        $reqx = Http::get($urlx);
        $content = $reqx->body();

        // Match the specific pattern in script tags
        preg_match('/_next\/static\/([a-f0-9]+)\/_buildManifest\.js/', $content, $matches);

        // Return the build ID if found, otherwise null
        return $matches[1] ?? null;
    }

    public function newReleaseLink()
    {
        $urlx = 'https://www.reelshort.com';
        $reqx = Http::get($urlx);
        $content = $reqx->body();

        // Match: <a ... href="SOMETHING">New Release</a>
        preg_match('/<a[^>]+href="([^"]+)"[^>]*>\s*New Release\s*<\/a>/i', $content, $matches);

        return $matches[1] ?? null;
    }

    public function stream($path, Request $request)
    {
        // https://v-mps.crazymaplestudios.com/vod-112094/d05ae771732f71f0b05286c6360c0102/e50e9e5a9cca4875bf042de9bf627c3e-925303b62503d55b32fa2536bc8dbf33-sd.m3u8
        // $base = "https://v-mps.crazymaplestudios.com/vod-112094/306eb4db093f71f080095114c0db0102";
        // $url = $base . '/' . $path;
        $url = $path;

        $response = Http::get($url);
        $contentType = $response->header('Content-Type', 'application/octet-stream');
        $body = $response->body();

        // If it's the playlist, rewrite .ts paths
        if (str_contains($contentType, 'application/vnd.apple.mpegurl')) {
            $body = preg_replace_callback('/(.*\.ts)/', function ($matches) {
                return url('/proxy-video/' . $matches[1]);
            }, $body);
        }

        return response($body, $response->status())
            ->header('Content-Type', $contentType);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
