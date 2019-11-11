@extends('base')

@section('content')

    <h1 class="text-3xl font-bold mb-6">Archives <small class="text-xl font-normal text-gray-700">{{ $count }} concerts référencés à Paris</small></h1>

    <nav class="leading-loose">
        @foreach($years as $year => $months)
            <h3 id="{{ str_slug($year) }}" class="text-sm font-semibold uppercase mt-10 mb-6">{{ $year }}</h3>

            @foreach($months as $key => $month)
                <a class="mr-4 hover:text-red-800 underline capitalize @if($current === $month) text-red-800 @endif @if($period == ($slugged = str_slug($month))) text-red-600 @endif" href="{{ route('archives', $slugged) }}">{{ $month }}</a>

                @if($key == 5)<br>@endif
            @endforeach
        @endforeach
    </nav>

    @if($period)
        <h2 class="my-12 text-2xl">Concerts à Paris en <strong class="font-medium">{{ title_case($start->monthName) }} {{ $start->year }}</strong></h2>

        @if(count($events))
            @include('events._event-list')
        @else
            <p>Aucun evenement pour cette periode.</p>
        @endif
    @endif
@endsection
