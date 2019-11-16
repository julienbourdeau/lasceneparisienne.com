@extends('base')

@section('content')

    <h1 class="text-3xl font-semibold mb-6">Salles de concert à Paris</h1>

    <div class="lg:flex lg:flex-row-reverse">
        <div class="mt-12 mb-12 lg:mb-2 lg:w-1/3 lg:mt-0">
            <h2 class="text-lg font-semibold mb-4">Top #5</h2>

            <ol class="">
                @foreach($top as $venue)
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
            </ol>

        </div>

        <div class="lg:w-2/3">
            <h2 class="text-lg font-semibold mb-4">Par ordre alphabetique</h2>

            @foreach ($venuesAlpha as $letter => $venues)
                <h3 class="font-black text-2xl">{{ $letter }}</h3>

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
            @endforeach
        </div>
    </div>

@endsection
