@extends('dramabox.layouts.master')
@section('content')
    <!-- Cover -->
    <section class="relative h-[50vh]">

        <!-- BACK BUTTON -->
        <a href="{{ route('dramabox.index') }}"
            class="absolute top-4 left-4 z-40 bg-black/60 text-white px-3 py-1 rounded text-sm">
            ← Back
        </a>
        <img src="{{ $detail->cover }}" class="w-full h-full object-cover opacity-70">
        <div class="absolute bottom-4 left-4">
            <h1 class="text-2xl font-bold">{{ $detail->bookName }}</h1>
            <p class="text-sm text-gray-300">Romance · {{ count($episodes) }} Episodes</p>
        </div>
    </section>

    <!-- Info -->
    <section class="px-4 mt-4">
        <p class="text-gray-300 text-sm">
            {{ $detail->introduction }}
        </p>

        <a href="{{ route('dramabox.watch', [$detail->bookId, $detail->bookName, 1]) }}"
            class="block mt-4 text-center py-3 bg-red-600 rounded-lg">
            ▶ Start Watching
        </a>
    </section>

    <!-- Episodes -->
    <section class="px-4 mt-6">
        <h3 class="text-lg font-semibold mb-3">Episodes</h3>
        <div class="grid grid-cols-4 gap-2">
            @foreach ($episodes as $eps)
                <a href="{{ route('dramabox.watch', [$detail->bookId, $detail->bookName, str_replace('EP ', '', $eps->chapterName)]) }}"
                    class="bg-gray-800 py-2 rounded text-center text-sm">{{ $eps->chapterName }}</a>
            @endforeach
        </div>
    </section>
@endsection
