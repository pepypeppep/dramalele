@extends('master')

@section('content')
    @if (str_contains(request()->userAgent(), 'Mobile') || str_contains(request()->userAgent(), 'Android'))
        @include('videom')
    @else
        @include('videod')
    @endif
@endsection
