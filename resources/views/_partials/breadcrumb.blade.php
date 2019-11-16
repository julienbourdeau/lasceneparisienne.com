<nav id="breadcrumb" class="hidden mb-8 text-gray-600 md:block">
    @foreach($breadcrumb->toArray()['itemListElement'] as $item)

        <a href="{{ $item['item']['url'] }}">
            {{ $item['item']['name'] }}
        </a>

        @unless($loop->last) > @endunless

    @endforeach
</nav>
