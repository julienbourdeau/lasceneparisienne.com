@extends('base')

@section('seo')
    <link rel="prev" href="{{ $events->previousPageUrl() }}">
    <link rel="next" href="{{ $events->nextPageUrl() }}">
@endsection

@section('content')

    <h1 class="text-3xl font-semibold mb-6">Prochains concerts à Paris</h1>

    <nav>
        @foreach($eventsPerMonth->keys() as $month)
            <a class="mr-4 hover:text-red-800 underline capitalize" href="#{{ str_slug($month) }}">{{ $month }}</a>
        @endforeach
    </nav>

    @foreach($eventsPerMonth as $month => $list)

    <h3 id="{{ str_slug($month) }}" class="text-sm font-bold uppercase mt-10 mb-6">{{ $month }}</h3>

    @include('events._event-list', ['events' => $list, 'showIcalNote' => $loop->first ? 3 : false])

    @endforeach

    {{ $events->onEachSide(1)->links() }}

@endsection
