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
        $url = config('services.dramabox.web') . '/_next/data/' . $this->buildId() . '/en/browse/0/' . $page . '.json';
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
        $url = config('services.dramabox.web') . '/_next/data/' . $this->buildId() . '/en/search/' . $page . '.json?searchValue=' . $q . '&page=' . $page;
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
        $req = Http::get(config('services.dramabox.web') . '/_next/data/' . $this->buildId() . '/en/drama/' . $id . '/' . $slug . '.json');
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
        $req = Http::get(config('services.dramabox.web') . '/_next/data/' . $this->buildId() . '/en/drama/' . $id . '/' . $slug . '.json');
        $response = json_decode($req->body());
        $data = $response->pageProps->bookInfo;
        $tabData = $response->pageProps->tabData;
        $chapterlist = $response->pageProps->chapterList;

        $movieId = explode('_', $episode)[0];
        $episode = explode('-', $episode)[1];
        $eps = $episode - 1;
        // dd($movieId, $episode, $eps);

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
        // ])->post(config('services.dramabox.api') . '/drama-box/chapterv2/batch/load', [
        //     'index' => $episode,
        //     'bookId' => $id
        // ]);

        // $timestamp = round(microtime(true) * 1000);
        // $event = [
        //     "eventName" => "play_startup_time",
        //     "type" => "TIME",
        //     "value" => 408,
        //     "tags" => [
        //         "cdn_domain_type" => "nawsvideo.dramaboxdb.com"
        //     ]
        // ];

        // $deviceId = "76040001-c487-4662-a4e7-c8acb6a9b655";
        // $androidId = "ffffffff8a134e7b8a134e7b00000000";
        // $tn = "Bearer ZXlKMGVZZQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SnlaV2RwYzNSbGNsUjVjR1VpT2lKVVJVMVFJaXdpZFhObGNrbGtJam95TmpBd05UVXdPVEo5LkxnSHZHVVZrM0lMakFKNGtoVlhmYXFTUTNGc016Z2VSZ2JyVWNoR2NFMTQ=";

        // $sn = $this->generateSn($timestamp, $event, $deviceId, $androidId, $tn, $privateKeyPem);

        $postData = [
            "postData" => [
                "name" => "tp_sess_start",
                "en" => 2,
                "intg" => "traceback",
                "plgn" => "traceback",
                "appKey" => "1ca825b8d",
                "isrc" => "LevelPlay",
                "lcts" => time() * 1000, // current timestamp in ms
                "coppa" => false,
                "dit" => "GAID",
                "uid" => "3937b3d5-bc1e-4961-84b4-e04a9c18ecb2",
                "uc" => true,
                "tz" => 7,
                "tpVer" => "7.25.2",
                "t" => "n",
                "model" => "Redmi Note 5",
                "manufacturer" => "Xiaomi",
                "platform" => "android",
                "osv" => "9",
                "pn" => "com.storymatrix.drama",
                "cf" => "com.google.android.packageinstaller",
                "vc" => "451",
                "vn" => "4.5.1",
                "dn" => "DramaBox",
                "nwav" => true,
                "mmav" => 667,
                "mmtt" => 2739,
                "size" => ["w" => 1080, "h" => 2030],
                "mtdt" => [
                    "abt" => "A",
                    "auid" => "42d2daa7-7560-4f76-ae85-1a229d7cc82c",
                    "idfi" => "72318f66-5ee8-4b3a-aa55-4838a6faec65"
                ],
                "dts" => round(microtime(true) * 1000),
                "ut" => 426552,
                "suid" => "3937b3d5-bc1e-4961-84b4-e04a9c18ecb2",
                "sid" => 2,
                "snm" => 1,
                "csld" => true,
                "lastTouch" => ["x" => -1, "y" => -1, "t" => -1, "u" => -1],
                "uto" => round(microtime(true) * 1000) - 300000,
                "ts" => round(microtime(true) * 1000),
                "uuid" => "2a46a8a2-a7fa-4501-a7a8-d42bfe1e07eb"
            ],
            "name" => "tp_sess_start",
            "en" => 2,
            "intg" => "traceback",
            "plgn" => "traceback",
            "appKey" => "1ca825b8d",
            "isrc" => "LevelPlay",
            "lcts" => time() * 1000,
            "coppa" => false,
            "dit" => "GAID",
            "uid" => "3937b3d5-bc1e-4961-84b4-e04a9c18ecb2",
            "uc" => true,
            "tz" => 7,
            "tpVer" => "7.25.2",
            "t" => "n",
            "model" => "Redmi Note 5",
            "manufacturer" => "Xiaomi",
            "platform" => "android",
            "osv" => "9",
            "pn" => "com.storymatrix.drama",
            "cf" => "com.google.android.packageinstaller",
            "vc" => "451",
            "vn" => "4.5.1",
            "dn" => "DramaBox",
            "nwav" => true,
            "mmav" => 667,
            "mmtt" => 2739,
            "size" => ["w" => 1080, "h" => 2030],
            "mtdt" => [
                "abt" => "A",
                "auid" => "42d2daa7-7560-4f76-ae85-1a229d7cc82c",
                "idfi" => "72318f66-5ee8-4b3a-aa55-4838a6faec65"
            ],
            "dts" => round(microtime(true) * 1000),
            "ut" => 426552,
            "suid" => "3937b3d5-bc1e-4961-84b4-e04a9c18ecb2",
            "sid" => 2,
            "snm" => 1,
            "csld" => true,
            "lastTouch" => ["x" => -1, "y" => -1, "t" => -1, "u" => -1],
            "uto" => round(microtime(true) * 1000) - 300000,
            "ts" => round(microtime(true) * 1000),
            "uuid" => "2a46a8a2-a7fa-4501-a7a8-d42bfe1e07eb"
        ];

        $sn = $this->generateSn($postData);

        echo "Generated Sn: " . $sn . "\n\n";

        // Test request
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sapi.dramaboxdb.com/drama-box/sf001/read/status/update?timestamp=' . round(microtime(true) * 1000),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"viewingDuration":0,"chapterId":"600466755","isLastSectionId":0,"isBottomBook":0,"chapterIndex":"2","bookId":"41000121270"}',
            CURLOPT_HTTPHEADER => array(
                'Host: sapi.dramaboxdb.com',
                'Version: 451',
                'Package-Name: com.storymatrix.drama',
                'P: 46',
                'Cid: XDASEO1000000',
                'Apn: 2',
                'Language: en',
                'Device-Id: 76040001-c487-4662-a4e7-c8acb6a9b655',
                'Android-Id: ffffffff8a134e7b8a134e7b00000000',
                'Tn: Bearer ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SnlaV2RwYzNSbGNsUjVjR1VpT2lKVVJVMVFJaXdpZFhObGNrbGtJam95TmpBd05UVXdPVEo5LkxnSHZHVVZrM0lMakFKNGtoVlhmYXFTUTNGc016Z2VSZ2JyVWNoR2NFMTQ=',
                'Sn: ' . $sn,
                'Content-Type: application/json',
                'User-Agent: Dalvik/2.1.0 (Linux; U; Android 9; Redmi Note 5 Build/PQ3A.190705.003)'
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        echo "HTTP Code: " . $httpCode . "\n";
        echo "Response: " . $response . "\n";
        dd($response);

        $respEpisode = Http::withHeaders([
            'Host' => 'sapi.dramaboxdb.com',
            'Version' => '451',
            'Package-Name' => 'com.storymatrix.drama',
            'P' => '46',
            'Cid' => 'XDASEO1000000',
            'Apn' => '2',
            'Language' => 'en',
            'Device-Id' => '76040001-c487-4662-a4e7-c8acb6a9b655',
            'Android-Id' => 'ffffffff8a134e7b8a134e7b00000000',
            'Tn' => 'Bearer ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SnlaV2RwYzNSbGNsUjVjR1VpT2lKVVJVMVFJaXdpZFhObGNrbGtJam95TmpBd05UVXdPVEo5LkxnSHZHVVZrM0lMakFKNGtoVlhmYXFTUTNGc016Z2VSZ2JyVWNoR2NFMTQ=',
            'Sn' => 'NNCs2hNk3+tf/zr6/37JiL4cdL+oV14sSUR6BQDr7yj+6ZpZyfOge1GBsJA0BNq9PD3wtJkywhiKvaAXIQ58K6JHeJ2CpOa9NZH7ZhavnKeBXrYQei0I5othMrcznS1pTcFtuGwZWpNestxWlAX/1Ej7V3FmR6J5nd7+xIgUN9zBbfqdnaxXwDTODVKHJDqxXT7rAlRP1pPTigJ+EIkciPZC0OHuKSh7r1zqDgjherXRJ13A3i2/J9Zt4a4PqTnHBYhL5tKGLuG5SNRqF86BhI79ObnJkFjq2cNbzsfLNNo0j4ZtGvXV8vN5mfLFzyWu05Evr2RrpYLLRlMg84tSdw==',
            'Content-Type' => 'application/json',
        ])
            ->timeout(30)
            ->post('https://sapi.dramaboxdb.com/drama-box/sf001/read/status/update?timestamp=1760441211026', [
                'viewingDuration' => 0,
                'chapterId' => $movieId,
                'isLastSectionId' => 0,
                'isBottomBook' => 0,
                'chapterIndex' => "$eps",
                'bookId' => $id,
            ]);
        $shootEpisode = json_decode($respEpisode);
        dd($shootEpisode);

        $response = Http::withHeaders([
            'Host' => 'sapi.dramaboxdb.com',
            'Version' => '451',
            'Package-Name' => 'com.storymatrix.drama',
            'P' => '46',
            'Cid' => 'XDASEO1000000',
            'Apn' => '2',
            'Language' => 'en',
            'Device-Id' => '76040001-c487-4662-a4e7-c8acb6a9b655',
            'Android-Id' => 'ffffffff8a134e7b8a134e7b00000000',
            'Tn' => 'Bearer ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SnlaV2RwYzNSbGNsUjVjR1VpT2lKVVJVMVFJaXdpZFhObGNrbGtJam95TmpBd05UVXdPVEo5LkxnSHZHVVZrM0lMakFKNGtoVlhmYXFTUTNGc016Z2VSZ2JyVWNoR2NFMTQ=',
            'Sn' => 'ageikU2ddkFkNTFTUt8IEnpfUdD22YS2sJuXQFL+qkTUjK2yRQe4pnzFVTPu80HNlIxj3vJ65clCP/l9eOCqyiE0B6RsypuvbexaZGct8oXSzKGfV9HXLkDBucFboy90l0rTU0xSWQUHg/WIcJvVs2N2RJKCg+rFvqouObrgoPkB8FVl+wryozKdxIxnXS6/SJn3O+Zdk/bThes5tU3fI8x4bQY4JVDFdfO82PLdI9bkSWjk3qu0DesEjzlRRNrPsc4Mc7qjKYmtA6wYlTjxpmjUfF00KVn1uGZLobl8EX4yVi7qh5aI8QvEs6+sybsYBXyAmYQ6fN6hOCK0ywI+zw==',
            'Content-Type' => 'application/json',
        ])
            ->timeout(30)
            ->post('https://sapi.dramaboxdb.com/drama-box/chapterv2/batch/load?timestamp=1760440840966', [
                'needRecommend' => false,
                'from' => 'book_ablum',
                'bookId' => $id,
            ]);

        // return $response->json();

        // Decode the JSON response
        $response = json_decode($response);

        $videoSrc = $response->data->chapterList[0]->cdnList[0]->videoPathList[0]->videoPath;
        // $videoSrc = '';

        return view('video', compact('data', 'chapterlist', 'episode', 'tabData', 'videoSrc'));
    }

    function generateSimpleSn($timestamp)
    {
        // Gunakan kunci dari HmacSHA1 (key pertama)
        $key = hex2bin("40496834763336734e6f526b334c26436f383765522d436e39526445774f523744");
        $iv = hex2bin("40496834763336734e6f526b334c2643");

        // Data sederhana untuk test
        $testData = [
            "name" => "tp_sess_start",
            "timestamp" => round(microtime(true) * 1000),
            "deviceId" => "76040001-c487-4662-a4e7-c8acb6a9b655"
        ];

        $dataString = json_encode($testData);
        $encrypted = openssl_encrypt($dataString, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);

        return base64_encode($encrypted);
    }

    function generateSn($postData)
    {
        // Kunci AES yang benar (dari Frida output)
        $aesKey = hex2bin("40496834763336734e6f526b334c26436f383765522d436e39526445774f523744");

        // Format data sesuai dengan yang terlihat di Frida
        $dataToEncrypt = "com.soomla.billing.util.AESObuscator-1|" . json_encode($postData);

        // IV harus 16 bytes (dari kunci pertama)
        $iv = hex2bin("40496834763336734e6f526b334c2643");

        // Encrypt dengan AES/CBC/PKCS7
        $encrypted = openssl_encrypt(
            $dataToEncrypt,
            'AES-128-CBC',
            $aesKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        return base64_encode($encrypted);
    }

    public function buildId()
    {
        $urlx = config('services.dramabox.web') . '/download';
        $reqx = Http::get($urlx);
        $content = $reqx->body();

        preg_match_all('/_next\/static\/([^\/]+)/', $content, $matches);

        $buildId = collect($matches[1] ?? [])
            ->first(fn($id) => preg_match('/^dramabox_prod_\d+$/', $id));

        return $buildId;
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
