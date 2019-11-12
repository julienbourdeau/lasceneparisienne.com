@extends('base')

@section('content')
    <div class="md:flex">
        <div class="md:w-2/3">

            <h1 class="text-3xl font-bold mb-8">{{ $venue->name }}</h1>

            <ul class="mt-8">
                <li><span class="font-semibold">Adresse:</span> {{ $venue->address_formatted }}</li>
                <li class="text-gray-500"><span class="font-semibold">GPS:</span> {{ $venue->lat }}, {{ $venue->lng }}</li>
            </ul>

            <h2 class="text-2xl font-thin mt-12">Concerts à venir ({{ count($upcomingEvents) }})</h2>

            <ol class="mt-2 mb-12">
            @foreach($upcomingEvents as $event)
                <li class="flex my-6">
                    <div>
                        <div class="bg-gray-100 rounded-lg border p-2 text-center w-12 md:w-24 mr-4">
                            <span class="hidden md:block text-sm">{{ $event->start_time->format('D') }}</span>
                            <span class="md:block font-bold">{{ $event->start_time->format('d M') }}</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-lg">
                            <a class="hover:text-red-800" href="{{ route('event', $event->slug) }}">{{ $event->name }}</a>
                            @include('_partials.admin-actions')
                        </h4>
                    </div>
                </li>
            @endforeach
            </ol>

            <h3 class="text-xl font-thin mt-12 mb-4">Concerts passés ({{ count($pastEvents) }})</h3>

            <ul class="list-disc ml-4">
            @foreach($pastEvents as $event)
                <li class="p-1">
                    <a class="hover:text-red-800" href="{{ $event->canonical_url }}">{{ $event->name }}</a>
                    <span class="text-red-900">{{ $event->start_time->diffForHumans() }}</span>
                </li>
            @endforeach
            </ul>

        </div>

        <div class="md:w-1/3">
        </div>
    </div>
@endsection
