<!doctype html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>

<div class="mt-48 m-auto w-64">
    <p class="text-gray-800 font-bold">Facebook Connect</p>
    <a href="{{ $loginUrl }}" class="block text-center font-semibold border-blue-800 bg-blue-600 text-white rounded px-4 py-2 my-4">
        Login
    </a>
    <p class="text-gray-500">App ID: {{ config('services.facebook.id') }}</p>
</div>

</body>
</html>
