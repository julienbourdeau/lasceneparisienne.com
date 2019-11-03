<!doctype html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('_partials/seo')

    {{--<script src="{{ asset('app.js') }}" defer></script>--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>

    @include('_partials.header')

    <div class="container">

        @yield('content')

    </div>

    @include('_partials.footer')


</body>
</html>
