<!doctype html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('_partials/seo')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')

</head>
<body>

    @include('_partials.header')

    <div class="container p-4 md:px-0 lg:px-0">

        @yield('content')

    </div>

    @include('_partials.footer')

    @include('_partials.analytics')
    @yield('script-footer')

</body>
</html>
