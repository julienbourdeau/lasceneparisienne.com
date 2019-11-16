@extends('base')

@section('seo')
    <meta property="og:image" content="{{ $event->cover_url }}">
    <meta property="og:title" content="{{ $event->name }}">
    <meta property="og:updated_time" content="{{ $event->updated_at->toIso8601String() }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="{{ $description }}"/>
    <meta name="twitter:title" content="{{ $event->name }} | La Scène Parisienne"/>
    <meta name="twitter:site" content="@concertsParis"/>
    <meta name="twitter:image" content="{{ $event->cover_url }}"/>
    <meta name="twitter:creator" content="@concertsParis"/>
@endsection

@section('content')

    @include('_partials.breadcrumb')

    <div class="lg:flex lg:flex-row-reverse">
        <div class="mt-12 mb-12 lg:mb-2 lg:w-1/3 lg:pl-8 lg:mt-0">
            <img class="w-full rounded-bl-lg object-center object-cover" src="{{ $event->cover_url }}" alt="{{ $event->name }}">

            <div class="hidden lg:block">
                <a class="block pt-4 hover:text-red-800" href="{{ route('event.ics', $event->uuid) }}">Ajoutez à votre agenda</a>
                <a class="block pt-4 hover:text-blue-600" href="https://www.facebook.com/events/{{ $event->id_facebook }}/">
                    Voir sur facebook
                </a>
            </div>
        </div>

        <div class="lg:w-2/3">

            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold mb-8 leading-none">
                {{ $event->name }}
                @include('_partials.admin-actions')
            </h1>

            <div class="my-6 md:my-12 p-4 bg-yellow-100">
                <p class="font-semibold text-red-900">{{ $event->start_time->format('l d F Y') }}</p>
                <p class="text-gray-800">{{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</p>
                <br>
                <h6 class="font-semibold text-red-900">{{ $event->venue->name }}</h6>
                <p class="text-gray-800">{{ $event->venue->address_formatted }}</p>
            </div>

            <div class="fb-event-description mt-8 text-sm leading-tight md:text-base">
                {!! $event->description_html !!}
            </div>

        </div>
    </div>

    <div class="flex justify-around mt-12 text-sm text-center lg:hidden">
        <a class="block px-3 mx-2 py-1 bg-gray-200 rounded hover:text-red-800" href="{{ route('event.ics', $event->uuid) }}">Ajoutez à votre agenda</a>
        <a class="block px-3 mx-2 py-1 bg-gray-200 rounded hover:text-blue-600" href="https://www.facebook.com/events/{{ $event->id_facebook }}/">
            Voir sur facebook
        </a>
    </div>
@endsection
