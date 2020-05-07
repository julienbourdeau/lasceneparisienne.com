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
            pas de rate limit, ni throttling mais cela peut changer en cas d'abus.</p>

        <p class="mb-3"><strong>L'API est accessible via le même domain que le site ({{ url('/') }}).</strong></p>
    </div>

    <div x-data="{{ $xData }}">

        @foreach($endpoints as $id => $endpoint)
            <div class="mb-4 border border-blue-200">
                <div  @click="{{ $id }} = !{{ $id }}" class="flex bg-blue-100 cursor-pointer">
                    <div class="text-blue-700 bg-blue-300 py-2 pl-4 pr-5 rounded-r-full">{{ $endpoint['verb'] }}</div>
                    <div class="w-full text-blue-700 py-2 px-4 font-mono">{{ $endpoint['endpoint'] }}</div>
                </div>
                <div x-show="{{ $id }}" class="bg-gray-100 overflow-scroll text-xs text-gray-800 py-4 px-2" style="display: none">
                    <pre>{{ $endpoint['response'] }}</pre>
                </div>
            </div>
        @endforeach

    </div>

    <div class="mt-16 mb-12">
        <h6 class="font-semibold text-lg">Exemple avec CURL</h6>
        <div class="bg-red-100 border-red-300 p-4 my-3">
            <code>curl -H 'Accept: application/json' -X GET \<br>
                {{ route('api.event', 'f603785f-8d4e-4943-bc7e-e9796b7c62ed') }}</code>
        </div>
    </div>

@endsection
