@extends('base')

@section('content')

    <h1 class="text-3xl font-semibold mb-6">Prochains concerts à Paris</h1>

    <nav>
        @foreach($allEvents->keys() as $month)
            <a class="mr-4 hover:text-red-800 underline capitalize" href="#{{ str_slug($month) }}">{{ $month }}</a>
        @endforeach
    </nav>

    @foreach($allEvents as $month => $events)

    <h3 id="{{ str_slug($month) }}" class="text-sm font-bold uppercase mt-10 mb-6">{{ $month }}</h3>

    @include('events._event-list')

    @endforeach

@endsection
