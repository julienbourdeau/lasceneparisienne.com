<title>{{ $title }}</title>

<meta name="description" content="{{ $description }}">


<meta property="og:site_name" content="La Scene Parisienne">
<meta property="og:locale" content="fr_FR">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ request()->fullUrl() }}">

@yield('seo')

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
