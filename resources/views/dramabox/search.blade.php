@extends('dramabox.layouts.master')

@section('content')
    <header class="px-4 py-3 bg-black sticky top-0">
        <form action="{{ route('dramabox.search') }}" method="GET">
            @csrf
            <input type="text" name="keyword" placeholder="Search dramas..." value="{{ request('keyword') }}"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white focus:outline-none" />
        </form>
    </header>

    <section class="px-4 mt-4 grid grid-cols-2 gap-4" id="movieListContainer"></section>
    @include('dramabox.partials.skeleton')
@endsection
@push('scripts')
    <script>
        $(function() {
            const container = $("#movieListContainer")
            const skeleton = $("#skeleton-template").html()

            @if (request('keyword'))
                // 1️⃣ Show skeletons immediately
                const SKELETON_COUNT = 10
                for (let i = 0; i < SKELETON_COUNT; i++) {
                    container.append(skeleton)
                }
            @endif

            $.ajax({
                url: "{{ route('dramabox.search') }}",
                data: {
                    keyword: "{{ request('keyword') }}"
                },
                method: "GET",
                success: function(response) {
                    container.empty() // remove skeletons
                    container.append(response)
                }
            })
        })
    </script>
@endpush
