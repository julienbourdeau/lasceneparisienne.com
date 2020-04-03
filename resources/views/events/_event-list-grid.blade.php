<ol class="mt-2 mb-12 flex flex-wrap">
    @foreach($events as $event)

        @if(isset($showIcalNote) && $showIcalNote)
            @if($loop->index == ($showIcalNote - 1))
                <li class="my-6 w-64 md:w-1/2  lg:w-1/3 px-4">
                    @include('_partials.add-to-calendar')
                </li>
            @endif
        @endif

        <li class="my-6 w-full max-w-sm md:w-1/2 lg:w-1/3 px-4">
            @include('events._event-list-item-with-cover')
        </li>
    @endforeach
</ol>
