@extends('base')

@section('content')

    @include('_partials.breadcrumb')

    <div class="flex">
        <div class="w-2/3">

            <h1 class="text-3xl font-bold mb-8">{{ $event->name }}</h1>

            <div class="my-4 p-4 bg-red-100 rounded-bl-lg shadow">
                <p class="font-semibold text-red-900">{{ $event->start_time->format('l d F Y') }}</p>
                <p class="text-gray-800">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</p>
                <br>
                <h6 class="font-semibold text-red-900">{{ $event->venue->name }}</h6>
                <p class="text-gray-800">{{ $event->venue->address_formatted }}</p>
            </div>

            <div class="mt-8">
                {!! $event->description_html !!}
            </div>

        </div>

        <div class="w-1/3 pl-8">
            <img class="w-full rounded-bl-lg object-center object-cover" src="{{ $event->cover['url'] }}" alt="{{ $event->name }}">
        </div>
    </div>
@endsection
