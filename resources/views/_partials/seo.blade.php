<title>{{ $title }}</title>

<meta name="description" content="{{ $description }}">

@isset($canonical)
    <link rel="canonical" href="{{ $canonical }}">
@endisset

@isset($breadcrumb)
    {!! $breadcrumb->toScript() !!}
@endisset

@isset($schema)
    @foreach($schema as $thing)
        {!! $thing->toScript() !!}
    @endforeach
@endisset
