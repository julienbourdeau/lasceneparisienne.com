{{--<title>{{ $seo['title'] }}</title>--}}

{{--<meta name="description" content="{{ $seo['description'] }}">--}}

{{--<link rel="canonical" href="{{ $seo['canonical_url'] }}">--}}

@isset($breadcrumb)
    {!! $breadcrumb->toScript() !!}
@endisset

@isset($schema)
    @foreach($schema as $thing)
        {!! $thing->toScript() !!}
    @endforeach
@endisset
