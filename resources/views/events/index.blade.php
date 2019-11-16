@extends('base')

@section('seo')
    <link rel="prev" href="{{ $events->previousPageUrl() }}">
    <link rel="next" href="{{ $events->nextPageUrl() }}">
@endsection

@section('content')

    <h1 class="text-3xl font-semibold mb-6">Prochains concerts à Paris</h1>

    <nav>
        @foreach($monthlyLinks as $periodName => $link)
            <a class="mr-4 hover:text-red-800 underline capitalize" href="{{ $link }}">{{ $periodName }}</a>
        @endforeach
    </nav>

    @foreach($eventsPerMonth as $month => $list)

    <h3 id="{{ str_slug($month) }}" class="text-sm font-bold uppercase mt-10 mb-6">{{ $month }}</h3>

    @include('events._event-list', ['events' => $list, 'showIcalNote' => $loop->first ? 3 : false])

    @endforeach

    {{ $events->onEachSide(1)->links() }}

@endsection
