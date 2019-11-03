@extends('base')

@section('content')

    <h1 class="text-3xl font-bold mb-6">Salles de concert à Paris</h1>

    <ul class="">
        @foreach($venues as $venue)
            <li class="my-6">
                <h4 class="font-semibold text-lg">
                    <a class="hover:text-red-800" href="{{ route('venue', $venue->slug) }}">
                        {{ $venue->name }}
                        <small class="text-sm text-red-900">
                            {{ $venue->upcoming_events_count }} concerts à venir
                        </small>
                    </a>
                </h4>
                <p class="text-gray-600">{{ $venue->address_formatted }}</p>
            </li>
        @endforeach
    </ul>

@endsection
