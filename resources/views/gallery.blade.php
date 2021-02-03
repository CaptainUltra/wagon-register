@extends('layouts.app')

@section('head-scripts')
    <script src="{{ mix('js/gallery.js') }}" defer></script>
@endsection

@section('content')
    @guest
        <Gallery></Gallery>
    @else
        <Gallery :user="{{auth()->user()}}" :permissions="{{(auth()->user() !== null) ? auth()->user()->getPermissionsSlugs() : null}}"></Gallery>
    @endguest
@endsection
