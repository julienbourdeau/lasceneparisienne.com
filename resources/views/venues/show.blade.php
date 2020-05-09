@extends('base')

@section('script-footer')

    @include('venues._map_script', ['venues' => new \App\Collection\VenueCollection([$venue])])

@endsection

@section('content')

    <h1 class="text-3xl font-bold mb-16">
        {{ $venue->name }}
        @include('_partials.admin-actions', ['model' => $venue])
    </h1>

    <div class="md:flex h-full">
        <div class="md:w-1/2 md:pr-4">
            <ul>
                <li><span class="font-semibold">Adresse:</span> {{ $venue->address_formatted }}</li>
            </ul>
        </div>
        <div class="md:w-1/2">
            <div id="map" class="w-full h-48 md:h-64"></div>
            <p class="text-gray-500"><span class="font-semibold">GPS:</span> {{ $venue->lat }}, {{ $venue->lng }}</p>
        </div>
    </div>

    <div class="mt-16 md:mt-24 lg:flex lg:flex-row-reverse">

        <div class="lg:w-1/3">
            <h2 class="text-2xl font-thin mb-2">Prochains concerts</h2>
            <div class="md:flex lg:flex-none lg:block">
                @forelse ($upcomingEvents->slice(0, $upcomingEvents->count() > 5 ? 2 : 1)->all() as $event)
                    <div class="my-6 md:w-1/2 lg:w-full">
                        @include('events._event-list-item-with-cover')
                    </div>
                @empty
                    <p>Aucun concert à venir.</p>
                @endforelse
            </div>
        </div>

        <div class="lg:w-2/3 lg:pr-12">
            <h2 class="text-2xl font-thin">Concerts à venir ({{ count($upcomingEvents) }})</h2>

            <ol class="mt-2 mb-12">
            @forelse($upcomingEvents as $event)
                <li class="flex my-6">
                    <div>
                        <div class="bg-gray-100 rounded-lg border p-2 text-center w-20 md:w-32 mr-2 md:mr-4">
                            <span class="hidden md:inline text-sm">{{ $event->start_time->format('D') }}</span>
                            <span class="font-bold">{{ $event->start_time->format('d M') }}</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-base md:text-lg pt-2">
                            <a class="hover:text-red-800" href="{{ route('event', $event->slug) }}">{{ $event->name }}</a>
                        </h4>
                    </div>
                </li>
            @empty
                <p>Aucun concert à venir.</p>
            @endforelse
            </ol>
        </div>
    </div>

    <div class="mt-16 md:mt-24">

        <h3 class="text-xl font-thin mb-4">Concerts passés ({{ count($pastEvents) }})</h3>

        <ul class="list-disc ml-4">
        @foreach($pastEvents as $event)
            <li class="p-1">
                <a class="hover:text-red-800" href="{{ $event->canonical_url }}">{{ $event->name }}</a>
                <span class="text-red-900">{{ $event->start_time->diffForHumans() }}</span>
            </li>
        @endforeach
        </ul>

    </div>

@endsection
