@extends('base')

@section('content')

    <h1 class="text-2xl font-bold mb-4 font-mono tracking-widest">
        REST API
    </h1>

    <div class="mb-12 lg:max-w-2xl">
        <p class="mb-3">Vous pouvez retouver tous les évènements futurs ainsi que salles de concerts via
        une API REST. Vous pouvez par exemple ajouter les prochains concerts à votre site,
        faire une app mobile...</p>

        <p class="mb-3">Je peux fournir des endpoints supplémentaires si besoin. Vous pouvez me contacter
        par email pour partager votre projet: julien@sigerr.ch</p>

        <p class="mb-3">L'API est accessible sans token, ni autre authentification. Il n'y a pour l'instant
        pas de rate limit, ni throttling mais cela peut changer en cas d'abus. L'API est accessible avec
        via le même domain que le site ({{ url('/') }}).</p>
    </div>

    <div class="mb-4 border border-blue-200">
        <div class="flex api-request cursor-pointer">
            <div class="text-blue-700 bg-blue-300 py-2 pl-4 pr-5 rounded-r-full">GET</div>
            <div class="w-full text-blue-700 bg-blue-100 py-2 px-4 font-mono">/api/events</div>
        </div>
        <div class="bg-gray-100 hidden api-response overflow-scroll text-xs text-gray-800 py-4 px-2">
            <pre>{{ json_encode(App\Event::paginate(2), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div class="mb-4 border border-blue-200">
        <div class="flex api-request cursor-pointer">
            <div class="text-blue-700 bg-blue-300 py-2 pl-4 pr-5 rounded-r-full">GET</div>
            <div class="w-full text-blue-700 bg-blue-100 py-2 px-4 font-mono">/api/event/{uuid}</div>
        </div>
        <div class="bg-gray-100 hidden api-response overflow-scroll text-xs text-gray-800 py-4 px-2">
            <pre>{{ json_encode($event = App\Event::where('start_time', '>', now())->firstOrFail(), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div class="mb-4 border border-blue-200">
        <div class="flex api-request cursor-pointer">
            <div class="text-blue-700 bg-blue-300 py-2 pl-4 pr-5 rounded-r-full">GET</div>
            <div class="w-full text-blue-700 bg-blue-100 py-2 px-4 font-mono">/api/venues</div>
        </div>
        <div class="bg-gray-100 hidden api-response overflow-scroll text-xs text-gray-800 py-4 px-2">
            <pre>{{ json_encode(App\Venue::paginate(2), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div class="mb-4 border border-blue-200">
        <div class="flex api-request cursor-pointer">
            <div class="text-blue-700 bg-blue-300 py-2 pl-4 pr-5 rounded-r-full">GET</div>
            <div class="w-full text-blue-700 bg-blue-100 py-2 px-4 font-mono">/api/venue/{uuid}</div>
        </div>
        <div class="bg-gray-100 hidden api-response overflow-scroll text-xs text-gray-800 py-4 px-2">
            <pre>{{ json_encode(App\Venue::first(), JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <div class="mt-16 mb-12">
        <h6 class="font-semibold text-lg">Exemple avec CURL</h6>
        <div class="bg-red-100 border-red-300 p-4 my-3">
            <code>curl -H 'Accept: application/json' -X GET {{ route('api.event', $event->uuid) }}</code>
        </div>
    </div>

    <script>

      $('.api-request').click(function() {
        $(this).siblings('.api-response').slideToggle();
      })
    </script>

@endsection
