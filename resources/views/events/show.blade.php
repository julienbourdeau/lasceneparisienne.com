@extends('base')

@section('content')

    @include('_partials.breadcrumb')

    <div class="md:flex">
        <div class="md:w-2/3">

            <h1 class="text-3xl font-bold mb-8 leading-none">{{ $event->name }}</h1>

            <div class="my-6 md:my-12 p-4 bg-yellow-100 hover:shadow">
                <p class="font-semibold text-red-900">{{ $event->start_time->format('l d F Y') }}</p>
                <p class="text-gray-800">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</p>
                <br>
                <h6 class="font-semibold text-red-900">{{ $event->venue->name }}</h6>
                <p class="text-gray-800">{{ $event->venue->address_formatted }}</p>
            </div>

            <div class="fb-event-description mt-8">
                {!! $event->description_html !!}
            </div>

        </div>

        <div class="mt-12 md:w-1/3 md:pl-8 md:mt-0">
            <img class="w-full rounded-bl-lg object-center object-cover" src="{{ $event->cover_url }}" alt="{{ $event->name }}">
        </div>
    </div>
@endsection
