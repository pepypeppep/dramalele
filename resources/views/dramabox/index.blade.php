@extends('dramabox.layouts.master')

@section('content')
    <!-- Navbar -->
    <header class="flex items-center justify-between px-4 py-3 bg-black sticky top-0 z-50">
        <h1 class="text-xl font-bold text-red-500">DramaBox</h1>
        <a href="{{ route('dramabox.search') }}" class="text-sm text-gray-300">Search</a>
    </header>

    <!-- Featured -->
    {{-- <section class="relative h-[60vh]">
        <img src="https://picsum.photos/800/1200" class="w-full h-full object-cover opacity-70">
        <div class="absolute bottom-6 left-4">
            <h2 class="text-2xl font-bold">Forbidden Love</h2>
            <p class="text-sm text-gray-300 mt-1">Romance · Drama</p>
            <a href="{{ route('dramabox.show', 1) }}" class="inline-block mt-3 px-4 py-2 bg-red-600 rounded">
                Watch Now
            </a>
        </div>
    </section> --}}

    <!-- Drama Rows -->
    <section class="px-4 mt-6">
        <h3 class="text-lg font-semibold mb-3">Latest</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="movieListContainer"></div>
    </section>
    @include('dramabox.partials.skeleton')
@endsection
@push('scripts')
    <script>
        $(function() {
            const container = $("#movieListContainer")
            const skeleton = $("#skeleton-template").html()

            // 1️⃣ Show skeletons immediately
            const SKELETON_COUNT = 10
            for (let i = 0; i < SKELETON_COUNT; i++) {
                container.append(skeleton)
            }

            // 2️⃣ Fetch data
            $.ajax({
                url: "{{ route('dramabox.index') }}",
                method: "GET",
                success: function(response) {
                    container.empty() // remove skeletons
                    container.append(response)
                },
                error: function() {
                    container.html(`
                    <p class="col-span-full text-center text-gray-400">
                        Failed to load dramas.
                    </p>
                `)
                }
            })
        })
    </script>
@endpush
