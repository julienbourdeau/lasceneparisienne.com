<ol class="mt-2 mb-12">
    @foreach($events as $event)

        @if(isset($showIcalNote) && $showIcalNote)
            @if($loop->index == ($showIcalNote - 1))
                <li class="md:float-right lg:float-right md:w-1/3 lg:w-1/4">
                    @include('_partials.add-to-calendar')
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
                    @if($event->canceled)
                        <span class="text-sm border rounded py-1 px-2 font-normal text-red-800 border-red-800">Annulé</span>
                    @elseif($event->soldout)
                        <span class="text-sm border rounded py-1 px-2 font-normal text-gray-700 border-gray-700">Complet</span>
                    @endif
                    <a class="hover:text-red-800" href="{{ route('event', $event->slug) }}">
                        {{ $event->name }}
                    </a>
                </h4>

                <span class="md:block"><a href="{{ route('venue', $event->venue->slug) }}">{{ $event->venue->name }}</a></span>
                <span class="md:block text-gray-600">{{ $event->venue->address_formatted }}</span>
                @auth @include('_partials.admin-actions', ['model' => $event]) @endauth
            </div>
        </li>
    @endforeach
</ol>
