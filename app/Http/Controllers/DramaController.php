<?php

namespace App\Http\Controllers;

use DOMXPath;
use DOMDocument;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 0);
        $url = env('DRAMABOX_WEB_URL') . '/_next/data/dramabox_prod_20250801/en/browse/0/' . $page . '.json';
        $req = Http::get($url);
        $response = json_decode($req->body());
        $booklist = $response->pageProps->bookList;
        $pages = $response->pageProps->pages - 1;
        $pageNo = $response->pageProps->pageNo;

        return view('index', compact('booklist', 'pages', 'pageNo'));
    }

    /**
     * Display a listing of the resource.
     */
    public function search(Request $request)
    {
        $page = $request->input('page', 1);
        $q = $request->input('q');
        $url = env('DRAMABOX_WEB_URL') . '/_next/data/dramabox_prod_20250801/en/search/' . $page . '.json?searchValue=' . $q . '&page=' . $page;
        $req = Http::get($url);
        $response = json_decode($req->body());
        $pageNo = $response->pageProps->pageNo;
        $totalNum = $response->pageProps->totalNum;
        $pages = $totalNum;
        $booklist = $response->pageProps->bookList;
        $totalPage = $response->pageProps->totalPage;

        return view('search', compact('booklist', 'totalNum', 'pageNo', 'pages', 'totalPage'));
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
        $req = Http::get(env('DRAMABOX_WEB_URL') . '/_next/data/dramabox_prod_20250801/en/drama/' . $id . '/' . $slug . '.json');
        $response = json_decode($req->body());
        $data = $response->pageProps->bookInfo;
        $chapterlist = $response->pageProps->chapterList;

        return view('show', compact('data', 'chapterlist'));
    }

    /**
     * Display the specified resource.
     */
    public function video(Request $request, $id, $slug, $episode)
    {
        $req = Http::get(env('DRAMABOX_WEB_URL') . '/_next/data/dramabox_prod_20250801/en/drama/' . $id . '/' . $slug . '.json');
        $response = json_decode($req->body());
        $data = $response->pageProps->bookInfo;
        $tabData = $response->pageProps->tabData;
        $chapterlist = $response->pageProps->chapterList;

        $movieId = explode('_', $episode)[0];
        $episode = explode('-', $episode)[1];

        $response = Http::withHeaders([
            'Tn' => 'Bearer ' . env('BEARER_TOKEN'),
            'Pline' => 'ANDROID',
            'Version' => '401',
            'Vn' => '4.0.1',
            'Userid' => '260055092',
            'Cid' => 'XDASEO1000000',
            'Package-Name' => 'com.storymatrix.drama',
            'Apn' => '2',
            'Device-Id' => '76040001-c487-4662-a4e7-c8acb6a9b655',
            'Android-Id' => '000000004eba8bae4eba8bae00000000',
            'Language' => 'en',
            'Current-Language' => 'en',
            'P' => '40',
            'Local-Time' => '2025-08-07 19:50:59.820 +0700',
            'Time-Zone' => '+0700',
            'Md' => 'Redmi Note 5',
            'Ov' => '9',
            'Mf' => 'XIAOMI',
            'Tz' => '-420',
            'Mcc' => '510',
            'Brand' => 'xiaomi',
            'Srn' => '1080x2160',
            'Ins' => '1754550077083',
            'Mbid' => '41000109056',
            'Mchid' => 'XDASEO1000000',
            'Nchid' => 'DRA1000042',
            'Lat' => '0',
            'Build' => 'Build/PKQ1.180904.001',
            'Locale' => 'en_US',
            'Over-Flow' => 'new-fly',
            'Instanceid' => 'f945e86b9e1953f086998f84f8ce8c06',
            'Country-Code' => 'ID',
            'Store-Source' => 'store_google',
            'Afid' => '1754550077072-7519988131849321120',
            'Is_vpn' => '0',
            'Is_root' => '1',
            'Is_emulator' => '0',
            'Sn' => 'rFBiMlOYuhlX18MSOsG/mH4nVzGgfHJEZ0pL8DbCS7neqiHAkBATjcu1Sjh9OuFDClYbtUaun4jjoXtpt16npXVEduWrFAi2YS8TZrG9pzf2sBtWU/qs2HtPrGpOudlMnDY9yLrED7ty8wbWy5jXzWmu7xOUMqCpDwQF4CFh0P6PMHa2EYlmDBb9jQw2Cq+f2IhEedjYV1OxyboLGpCd1R3RqQwY2L3m9pw4uj363I8trQLYujRDJ3d5vCVkLl9tp/TM/vAMCvVg50Wvo3Ly4cpyydQRq4TNBObhuNJ3EpmD36TlppW9KastcjqJx/bwriNP/f0YeMrZbYXX9c76qQ==',
            'Active-Time' => '495946',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Accept-Encoding' => 'gzip, deflate, br',
            'User-Agent' => 'okhttp/4.10.0'
        ])->post(env('DRAMABOX_API_URL') . '/drama-box/chapterv2/batch/load', [
            'index' => $episode,
            'bookId' => $id
        ]);

        // Decode the JSON response
        $response = json_decode($response);

        $videoSrc = $response->data->chapterList[0]->cdnList[0]->videoPathList[0]->videoPath;
        // $videoSrc = '';

        return view('video', compact('data', 'chapterlist', 'episode', 'tabData', 'videoSrc'));
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
