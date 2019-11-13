<ol class="mt-2 mb-12">
    @foreach($events as $event)

        @if(isset($showIcalNote) && $showIcalNote)
            @if($loop->index == ($showIcalNote - 1))
                <li class="md:float-right lg:float-right md:w-1/3 lg:w-1/4">
                    <a class="block p-4 bg-yellow-100 hover:bg-yellow-200 hover:shadow" href="{{ route('ics') }}">
                        <p class="font-medium">Ajoutez à votre agenda</p>
                        <p><small>Tous les concerts automatiquement dans votre calendrier avec le flux ics</small></p>
                    </a>
                </li>
            @endif
        @endif

        <li class="flex my-6">
            <div>
                <div class="bg-gray-100 rounded-lg border p-2 text-center w-12 md:w-24 mr-4">
                    <span class="hidden md:block text-sm">{{ $event->start_time->format('D') }}</span>
                    <span class="md:block font-bold">{{ $event->start_time->format('d M') }}</span>
                    <span class="hidden md:block">{{ $event->start_time->format('H:i') }}</span>
                </div>
            </div>
            <div>
                <h4 class="font-semibold text-lg">
                    <a class="hover:text-red-800" href="{{ route('event', $event->slug) }}">{{ $event->name }}</a>
                    @include('_partials.admin-actions')
                </h4>
                <p class=""><a href="{{ route('venue', $event->venue->slug) }}">{{ $event->venue->name }}</a></p>
                <p class="text-gray-600">{{ $event->venue->address_formatted }}</p>
            </div>
        </li>
    @endforeach
</ol>
