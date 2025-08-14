@extends('master')

@section('content')
    {{-- @if (str_contains(request()->userAgent(), 'Mobile') || str_contains(request()->userAgent(), 'Android')) --}}
    @include('reelshort.videom')
    {{-- @else
        @include('reelshort.videod')
    @endif --}}
@endsection
