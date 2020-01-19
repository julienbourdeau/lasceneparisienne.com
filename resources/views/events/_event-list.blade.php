<ol class="mt-2 mb-12">
    @foreach($events as $event)

        @if(isset($showIcalNote) && $showIcalNote)
            @if($loop->index == ($showIcalNote - 1))
                <li class="md:float-right lg:float-right md:w-1/3 lg:w-1/4">
                    @include('_partials.add-to-calendar')
                </li>
            @endif
        @endif

        <li class="my-6">
            @include('events._event-list-item-simple')
        </li>
    @endforeach
</ol>
