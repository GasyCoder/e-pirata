@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-white">Test des images SVG</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @php
                $images = ['treasure-map', 'compass', 'ship', 'chest', 'skull'];
            @endphp
            
            @foreach($images as $image)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h2 class="text-white mb-2">{{ $image }}.svg</h2>
                    <div class="h-48 bg-gray-900 rounded-lg">
                        <img src="{{ asset('images/enigmas/' . $image . '.svg') }}"
                             alt="{{ $image }}"
                             class="w-full h-full object-contain p-4">
                    </div>
                    <div class="mt-2 text-gray-400">
                        URL: {{ asset('images/enigmas/' . $image . '.svg') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
