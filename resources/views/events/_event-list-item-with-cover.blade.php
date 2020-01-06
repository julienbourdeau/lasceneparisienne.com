
<div class="shadow-md">
    <div class="h-48 flex-none bg-cover rounded-t text-center overflow-hidden border-r border-t border-l border-gray-300 relative" style="background-image: url('{{ $event->cover_url }}')" title="Cover for {{ $event['name'] }}">

        @if($event->canceled)
            <div class="bg-red-700 opacity-50 absolute bottom-0 w-full h-10 pt-3"></div>
            <div class="absolute bottom-0 w-full h-10 pt-3 text-sm font-bold uppercase text-gray-100">Annulé</div>
        @elseif($event->soldout)
            <div class="">Complet</div>
        @endif
    </div>

    <div class="w-full border-r border-b border-l border-gray-300 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-4">
            <p class="text-sm text-red-900 flex items-center">
                {{ $event->start_time->format('l j M - H:i') }}
            </p>
            <a class="text-black font-bold text-xl mb-2 no-underline break-words" href="{{ $event['canonical_url'] }}">
                {{ title_case($event->name) }}
            </a>
        </div>

        <div class="text-sm">
            <p class="text-black font-medium leading-none">{{ $event->venue->name }}</p>
            <p class="text-gray-600">{{ $event->venue->address_formatted }}</p>
        </div>

    </div>
</div>
