@extends('base')

@section('content')

    <div class="bg-yellow-100 p-3 mb-6 lg:mb-12">
        <p class="lg:max-w-xl">{{ $description }}</p>
    </div>
    <div>
        <h1 class="text-2xl font-bold mb-4">
            Concerts cette semaine à Paris
            <small class="text-sm text-red-900 hover:text-red-800 pl-3"><a href="{{ route('events') }}">Voir tous</a></small>
        </h1>

        @include('events._event-list-with-cover', ['events' => $thisWeek])

    </div>

    <div class="md:flex mt-6">
        <div class="md:w-2/3">
            <h2 class="text-2xl font-medium mb-8">
                La semaine prochaine
                <small class="text-sm text-red-900 hover:text-red-800 pl-3"><a href="{{ route('events') }}">Voir tous</a></small>
            </h2>

            @include('events._event-list', ['events' => $nextWeek])
        </div>

        <div class="md:w-1/3 md:pl-8">
            @include('_partials.add-to-calendar')
        </div>
    </div>
@endsection
