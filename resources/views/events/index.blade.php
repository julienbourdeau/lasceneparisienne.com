@extends('base')

@section('content')

    <h1 class="text-3xl font-bold mb-6">Concerts à Paris</h1>

    <nav>
        @foreach($allEvents->keys() as $month)
            <a class="mr-4 hover:text-red-800 underline capitalize" href="#{{ str_slug($month) }}">{{ $month }}</a>
        @endforeach
    </nav>

    @foreach($allEvents as $month => $events)

    <h3 id="{{ str_slug($month) }}" class="text-sm font-bold uppercase mt-10 mb-6">{{ $month }}</h3>

    <ol class="mt-2 mb-12">
        @foreach($events as $event)
        <li class="flex my-6">
            <div>
                <div class="bg-gray-100 rounded-lg border p-2 text-center w-12 md:w-24 mr-4">
                    <span class="hidden md:block text-sm">{{ $event->start_time->format('D') }}</span>
                    <span class="md:block font-bold">{{ $event->start_time->format('d M') }}</span>
                    <span class="hidden md:block">{{ $event->start_time->format('H:m') }}</span>
                </div>
            </div>
            <div>
                <h4 class="font-semibold text-lg">
                    <a class="hover:text-red-800" href="{{ route('event', $event->slug) }}">{{ $event->name }}</a>
                </h4>
                <p class="">{{ $event->venue->name }}</p>
                <p class="text-gray-600">{{ $event->venue->address_formatted }}</p>
            </div>
        </li>
        @endforeach
    </ol>
    @endforeach

@endsection
