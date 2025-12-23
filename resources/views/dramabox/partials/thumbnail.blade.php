@foreach ($resp as $data)
    <a href="{{ route('dramabox.show', [$data->bookId, $data->bookName]) }}" class="block">
        <div class="aspect-[2/3] overflow-hidden rounded-lg bg-gray-800">
            <img src="{{ $data->coverWap ?? $data->cover }}" class="w-full h-full object-cover" loading="lazy">
        </div>
        <p class="text-sm mt-2 text-white line-clamp-2">
            {{ $data->bookName }}
        </p>
    </a>
@endforeach
