
<nav id="breadcrumb" class="mb-8 text-gray-500">
    <p>
        @foreach($breadcrumb->toArray()['itemListElement'] as $item)

            <a href="{{ $item['item']['url'] }}">
                {{ $item['item']['name'] }}
            </a>

            @unless($loop->last) > @endunless

        @endforeach
    </p>
</nav>
