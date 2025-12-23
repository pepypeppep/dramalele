<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DramaboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $req = Http::withHeaders([
                'accept' => '*/*',
            ])->get('https://dramabox.sansekai.my.id/api/dramabox/latest');
            $resp = json_decode($req->body());

            return view('dramabox.partials.thumbnail', compact('resp'));
        }
        return view('dramabox.index');
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
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $req = Http::withHeaders([
                'accept' => '*/*',
            ])->get('https://dramabox.sansekai.my.id/api/dramabox/search?query=' . $request->keyword);
            $resp = json_decode($req->body());

            return view('dramabox.partials.thumbnail', compact('resp'));
        }

        return view('dramabox.search');
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $title)
    {
        $req = Http::withHeaders([
            'accept' => '*/*',
        ])->get('https://dramabox.sansekai.my.id/api/dramabox/search?query=' . $title);
        $detail = json_decode($req->body())[0];

        if (session("movie_$id")) {
            $episodes = session("movie_$id");
        } else {
            $req2 = Http::withHeaders([
                'accept' => '*/*',
            ])->get('https://dramabox.sansekai.my.id/api/dramabox/allepisode?bookId=' . $id);
            $episodes = json_decode($req2->body());

            session([
                "movie_$id" => $episodes,
            ]);
        }

        return view('dramabox.show', compact('detail', 'episodes'));
    }

    /**
     * Display the specified resource.
     */
    public function watch($id, $title, $episode)
    {
        $episodes = session("movie_$id");
        $eps = array_values(array_filter($episodes, function ($epsd) use ($episode) {
            return $epsd->chapterName == "EP " . $episode;
        }))[0];

        return view('dramabox.watch', compact('id', 'title', 'eps', 'episode'));
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
