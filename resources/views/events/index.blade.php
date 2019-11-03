@extends('base')

@section('content')

    <h1 class="text-3xl font-bold mb-6">Concerts à Paris</h1>

    <nav>
        @foreach($allEvents->keys() as $month)
            <a class="mr-4 hover:text-red-800 underline" href="#{{ str_slug($month) }}">{{ $month }}</a>
        @endforeach
    </nav>

    @foreach($allEvents as $month => $events)

    <h3 id="{{ str_slug($month) }}" class="text-sm font-bold uppercase my-6">{{ $month }}</h3>

    <ol class="mt-2 mb-12">
        @foreach($events as $event)
        <li class="flex my-6">
            <div class="bg-gray-100 rounded-lg border p-2 text-center w-24 mr-4">
                <span class="font-bold">{{ $event->start_time->format('d M') }}</span> <br>
                <span>{{ $event->start_time->format('H:m') }}</span>
            </div>
            <div>
                <h4 class="font-semibold text-lg">{{ $event->name }}</h4>
                <p class="">{{ $event->venue->name }}</p>
                <p class="text-gray-600">{{ $event->venue->address_formatted }}</p>
            </div>
        </li>
        @endforeach
    </ol>
    @endforeach

@endsection
