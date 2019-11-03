@extends('base')

@section('content')
    <div class="flex">
        <div class="w-2/3">

            <h1 class="text-3xl font-bold mb-8">{{ $venue->name }}</h1>

            <ul class="mt-8">
                <li><span class="font-semibold">Adresse:</span> {{ $venue->address_formatted }}</li>
                <li class="text-gray-500"><span class="font-semibold">GPS:</span> {{ $venue->lat }}, {{ $venue->lng }}</li>
            </ul>

        </div>

        <div class="w-1/3 pl-8">
        </div>
    </div>
@endsection
